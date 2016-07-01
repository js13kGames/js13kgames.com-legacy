'use strict';

var fs = require('fs');
var multiparty = require('multiparty');

var config = require('../config');
var Edition = require('../models/edition');
var Category = require('../models/category');
var Submission = require('../models/submission');
var SubmitForm = require('../models/submit_form');

var SubmitController = {};

SubmitController.get = function(req, res) {
  var a = Category.findAll({
    include: [{
      model: Edition,
      where: {
        slug: 2015 //req.params.year
      }
    }]
  }).then(function(rows) {
    var sForm = req.session.submitForm;
    delete req.session.submitForm;
    res.render('submit', { categories: rows, csrfToken: req.session.csrf, form: sForm });
  });
};

SubmitController.post = function(req, res, next) {
  var form = new multiparty.Form({autoFiles: true});

  form.parse(req, function(err, fields, files) {
    var sForm = new SubmitForm(fields, files);

    // Check csrf
    if (sForm.csrf !== req.session.csrf) {
      res.redirect('/submit/invalid_csrf');
      next();
    }
    // Remove @s from twitter handler
    if (sForm.twitter.indexOf('@') >= 0) {
      sForm.twitter.replace('@', '');
    }

    delete sForm.csrf;
    sForm.editionId = config.games.editionId;

    Submission.build(sForm)
    .save()
    .then(function(obj) {
      obj.saveFiles();
      res.render('submit_success', { email: obj.get('email') });
    })
    .catch(function(err) {
      req.session.submitForm = sForm;
      if (err.errors.length > 0) {
        req.session.submitForm.errors = {};
        err.errors.forEach(function(e) {
          req.session.submitForm.errors[e.path] = e.message;
        });
      }
      res.redirect('/submit');
    });
  });
};


SubmitController.invalid = function(req, res, next) {
  res.render('submit_invalid');
};

module.exports = SubmitController;
