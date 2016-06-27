var config = require('../config');
var Edition = require('../models/edition');
var Category = require('../models/category');
var Submission = require('../models/submission');
var multiparty = require('multiparty');

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
    res.render('submit', {categories: rows, csrf: '1234567890'});
  });
};

SubmitController.post = function(req, res) {
  var form = new multiparty.Form({autoFiles: true});

  form.parse(req, function(err, fields, files) {
    Submission.build({
      title: fields.title[0],
      slug: stringToSlug(fields.title[0]),
      author: fields.author[0],
      twitter: fields.twitter[0],
      categories: fields['categories[]'],
      email: fields.email[0],
      websiteUrl: fields.website_url[0],
      githubUrl: fields.github_url[0],
      description: fields.description[0],
      fileZip: files.file[0],
      smallScreenshot: files.small_screenshot[0],
      bigScreenshot: files.big_screenshot[0],
      editionId: config.games.editionId
    })
    .save()
    .then(function(obj) {
      res.render('submit_success', { email: obj.get('email') });
    })
    .catch(function(error) {
      console.log('err', error);

      var a = Category.findAll({
        include: [{
          model: Edition,
          where: {
            slug: 2015 //req.params.year
          }
        }]
      }).then(function(rows) {
        res.render('submit', {categories: rows, csrf: '1234567890'});
      });
    });
  });
};

var stringToSlug = function(value) {
  value = value.toLowerCase();
  value = value.replace(' ', '_');
  return value;
};

module.exports = SubmitController;
