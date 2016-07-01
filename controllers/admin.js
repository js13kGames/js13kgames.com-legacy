var User = require('../models/user');
var Edition = require('../models/edition');
var Submission = require('../models/submission');

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

AdminController.show = function(req, res) {
  var a = Submission.find({
    where: {
      slug: req.params.slug
    },
    include: [{
      model: Edition,
      where: {
        slug: req.params.year
      }
    }]
  }).then(function(entry) {
    sequelize.query("SELECT cs.category_id, c.title FROM category_submission cs, categories c WHERE cs.submission_id = ? AND cs.category_id = c.id", {
      replacements: [entry.id],
      type: sequelize.QueryTypes.SELECT
    }).then(function(cats) {
      entry.categories = cats.map(function(c) {
        return c.title;
      }).join(', ');
      entry.description = entry.description.split("\r\n").filter(function(x) { return x !== "" }).map(function(x) { return "<p>" + x + "</p>" }).reduce(function(x, y) { return x + y });
      res.render('entry', { entry: entry });
    });
  });
};

module.exports = AdminController;
