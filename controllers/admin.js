var User = require('../models/user');
var Vote = require('../models/vote');
var Comment = require('../models/comment');
var Edition = require('../models/edition');
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
  res.render('admin');
};

AdminController.submissions = function(req, res) {
  var a = Submission.findAll({
    //where: {
    //  active: 0
    //},
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
    res.render('admin_submissions', { entries: results, year: req.params.year, count: results.length });
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
    Comment.findAll({
      where: {
        user_id: req.session.user.id,
        submission_id: req.params.id
      }
    })
  ]).then(function(results) {
    res.render('admin_show', {
      user: req.session.user,
      entry: results[0],
      comments: results[2],
      criteria: results[1].map(function(x) {
        var scores = [];
        for (var i=0; i<=x.score; i++) scores.push(i);

        return {
          obj: x,
          scores: scores
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

  Promise.all(criteria.map(function(c) {
    return castVote(req, c);
  }))
  .then(function(votes) {
    res.json({status: 'ok'});
  });
};

AdminController.comment = function(req, res, next) {
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
  return Vote.findOrInitialize({
    where: {
      user_id: req.body.user_id,
      submission_id: req.body.submission_id,
      criterion_edition_id: criterion.id
    }
  })
  .spread(function(vote, created) {
    return vote;
  })
  .then(function(vote) {
    vote.value = criterion.score;
    return vote.save();
  });
};

module.exports = AdminController;
