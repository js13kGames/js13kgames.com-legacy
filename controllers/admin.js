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

module.exports = AdminController;