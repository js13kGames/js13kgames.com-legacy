var config = require('../config');
var messages = require('../messages');
var User = require('../models/user');
var Vote = require('../models/vote');
var Comment = require('../models/comment');
var Edition = require('../models/edition');
var Category = require('../models/category');
var Submission = require('../models/submission');
var Criterion = require('../models/criterion');
var CriterionEdition = require('../models/criterion_edition');

var AdminController = {};

AdminController.form = function(req, res) {
  if (req.session.user) {
    res.redirect('/admin');
  } else {
    res.render('login', {csrfToken: req.session.csrf });
  }
};

AdminController.login = function(req, res) {
  // Check csrf
  if (req.body.csrf !== req.session.csrf) {
    return res.redirect('/admin/login_error');
  }

  User.find({
    where: {
      email: req.body.email,
      password: req.body.password
    }
  })
  .then(function(user) {
    req.session.user = user.toJSON();
    res.redirect('/admin');
  })
  .catch(function(err) {
    res.redirect('/admin/login_error');
  });
};

AdminController.panel = function(req, res) {
  res.render('admin', { isSuperUser: isSuperUser(req) });
};

AdminController.submissions = function(req, res) {
  var active = 1;
  var showPending = req.query.filter === 'pending';
  var isSu = isSuperUser(req);

  if (showPending) {
    if (isSu) {
      active = 0;
    } else {
      return res.render('admin_no_permissions');
    }
  }

  var a = Submission.findAll({
    where: {
      active: active
    },
    include: [{
      model: Edition,
      where: {
        slug: req.params.year
      }
    }],
    order: [
      ['active', 'ASC'],
      ['created_at', 'DESC']
    ]
  }).then(function(results) {
    res.render('admin_submissions', {
      entries: results,
      year: req.params.year,
      count: results.length,
      showPending: showPending,
      isSuperUser: isSuperUser(req)
    });
  });
};

AdminController.accept = function(req, res, next) {
  var a = Submission.find({
    where: {
      id: req.params.id,
      active: 0
    }
  }).then(function(result) {
    if (result) {
      result.active = 1;
      result
      .save()
      .then(function(result) {
        // TODO: send emails
        res.json({ status: 'ok' });
      });
    } else {
      res.status(404).send(messages.error.submissionNotFoundOrAccepted);
    }
  })
  .catch(function(err) {
    res.status(500).send(err);
  });
};

AdminController.reject = function(req, res, next) {
  var a = Submission.find({
    where: {
      id: req.params.id,
      active: 0
    }
  }).then(function(result) {
    if (result) {
      result
      .destroy({ force: true })
      .then(function(result) {
        // TODO: send emails
        res.json({ status: 'ok' });
      });
    } else {
      res.status(404).send(messages.error.submissionNotFoundOrRejected);
    }
  })
  .catch(function(err) {
    console.log('err', err);
    res.status(500).send(err);
  });
};

AdminController.show = function(req, res) {
  var result = Promise.all([
    Submission.find({
      where: {
        id: req.params.id,
        active: 1
      }
    }),
    CriterionEdition.findAll({
      include: [{
        model: Edition,
        where: {
          active: true
        }
      }, {
        model: Criterion
      }]
    }),
    Comment.findOne({
      where: {
        user_id: req.session.user.id,
        submission_id: req.params.id
      }
    }),
    Vote.findAll({
      where: {
        user_id: req.session.user.id,
        submission_id: req.params.id
      },
      include: [{
        model: CriterionEdition
      }]
    })
  ]).then(function(results) {
    res.render('admin_show', {
      user: req.session.user,
      entry: results[0],
      comment: results[2],
      criteria: results[1].map(function(x) {
        var item = results[3].find(function(z) { return z.criterion_edition_id === x.id });
        var current = (item) ? item.value / item.criterion_edition.multiplier : -1;
        var scores = [];
        for (var i=0; i<=x.score; i++) scores.push(i);

        return {
          obj: x,
          scores: scores,
          default: current
        }
      })
    });
  })
  .catch(function(err) {
    console.log('err', err);
    // FIXME: Show a graceful error
    res.status(500).send(err);
  });
};

AdminController.vote = function(req, res, next) {
  var criteria = getCriteriaData(req.body);

  var requests = criteria.map(function(c) {
    return castVote(req, c);
  });
  if (req.body.comment && req.body.comment !== '') {
    var promise = Comment.findOrInitialize({
      where: {
        user_id: req.session.user.id,
        submission_id: req.body.submission_id
      }
    })
    .spread(function(comment, created) {
      return comment;
    })
    .then(function(comment) {
      comment.text = req.body.comment;
      return comment.save();
    });
    requests.push(promise);
  }

  Promise.all(requests)
  .then(function(results) {
    var score = 0;
    results.forEach(function(v) {
      if (v.value) score += v.value;
    });
    return score;
  })
  .then(function(score) {
    return Submission.find({
      where: {
        id: req.body.submission_id
      }
    })
  })
  .then(function(submission) {
    return submission.recalculateAvgScore();
  })
  .then(function(submission) {
    res.json({ status: 'ok', score: submission.score });
  });
};

AdminController.editions = function(req, res, next) {
  Edition.findAll()
  .then(function(editions) {
    res.render('editions', { editions: editions, count: editions.length });
  });
};

AdminController.newEdition = function(req, res, next) {
  Criterion.findAll({
    where: {
      active: 1
    }
  })
  .then(function(criteria) {
    res.render('new_edition', { year: new Date().getFullYear(), criteria: criteria });
  });
};

AdminController.createEdition = function(req, res, next) {
  var objCriteria = {};
  var arrCriteria = [];
  var currentEdition;

  for (var key in req.body) {
    if (key.indexOf('criterion') >= 0) {
      var param = key.split('-')[1];
      var index = key.split('-')[2];
      if (!objCriteria[index]) {
        objCriteria[index] = {
          id: index,
          enabled: false,
          range: null,
          multiplier: null
        }
      }

      if (param === 'enable') objCriteria[index].enabled = (req.body[key] === 'on') ? true : false;
      if (param === 'range' || param === 'multiplier') objCriteria[index][param] = req.body[key];
    }
  }
  for (var key in objCriteria) arrCriteria.push(objCriteria[key]);
  arrCriteria = arrCriteria.filter(function(x) { return x.enabled });

  Edition.update({ active: false }, { where: {} })
  .then(function() {
    return Edition.create({
      title: req.body.year,
      slug: req.body.slug,
      theme: req.body.theme,
      active: false
    })
  })
  .then(function(edition) {
    currentEdition = edition.get('id');

    return Promise.all(arrCriteria.map(function(c) {
      return CriterionEdition.create({
        edition_id: edition.get('id'),
        criterion_id: c.id,
        score: c.range,
        multiplier: c.multiplier
      })
    }));
  })
  .then(function(results) {
    return Promise.all([
      Category.create({ title: 'Desktop', edition_id: currentEdition }),
      Category.create({ title: 'Mobile', edition_id: currentEdition }),
      Category.create({ title: 'Server', edition_id: currentEdition }),
    ]);
  })
  .then(function(results) {
    res.send({status: 'ok'});
  })
  .catch(function(err) {
    console.log('err', err);
    res.status(500).send(err);
  });
};

AdminController.updateEdition = function(req, res, next) {
  Edition.find({
    where: {
      id: req.params.id,
      active: (req.body.action === 'open') ? 0 : 1
    }
  }).then(function(edition) {
    if (edition === null) {
      throw new Error(messages.error.editionNotFoundOrNoLongerActive);
    }
    edition.active = (req.body.action === 'open') ? 1 : 0;
    return edition.save();
  })
  .catch(function(err) {
    res.status(500).send(err);
  })
  .then(function(edition) {
    res.send({ status: 'ok', id: req.params.id, action: req.body.action });
  });
};

AdminController.removeEdition = function(req, res, next) {
  Edition.find({
    where: {
      id: req.params.id,
      active: 1
    }
  }).then(function(edition) {
    if (edition === null) {
      throw new Error(messages.error.editionNotFoundOrNoLongerActive);
    }
    return Promise.all([
      CriterionEdition.destroy({
        where: {
          edition_id: edition.id
        }
      }),
      Category.destroy({
        where: {
          edition_id: edition.id
        }
      }),
      edition.destroy()
    ]);
  })
  .catch(function(err) {
    res.status(500).send(err);
  })
  .then(function(results) {
    res.send({status: 'ok', id: req.params.id});
  });
};

var isSuperUser = function(req) {
  return req.session.user.level >= config.admin.superUserLevel
};

var getCriteriaData = function(body) {
  return Object.keys(body).map(function(x) {
    if (x.indexOf('criterion') >= 0) {
      var parts = x.split('-');
      return {
        id: parts[parts.length - 1],
        score: body[x]
      };
    }
  }).filter(function(x) {
    return x !== undefined;
  });
};

var castVote = function(req, criterion) {
  var multiplier = 1;

  return CriterionEdition.find({
    where: {
      id: criterion.id
    }
  })
  .then(function(c) {
    multiplier = c.multiplier;

    return Vote.findOrInitialize({
      where: {
        user_id: req.body.user_id,
        submission_id: req.body.submission_id,
        criterion_edition_id: criterion.id
      }
    })
  })
  .spread(function(vote, created) {
    return vote;
  })
  .then(function(vote) {
    vote.value = criterion.score * multiplier;
    return vote.save();
  });
};

module.exports = AdminController;
