var config = require('../config');
var Sequelize = require('sequelize');
var sequelize = new Sequelize(config.db.name, null, null, config.db.connection);

var Submission = require('../models/submission');
var Edition = require('../models/edition');
var Category = require('../models/category');

var EntriesController = {};

EntriesController.list = function(req, res) {
  var a = Submission.findAll({
    include: [{
      all: true,
      nested: true
    }]
  }).then(function(rows) {
    res.render('entries', { entries: rows });
  });
};

EntriesController.show = function(req, res) {
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

module.exports = EntriesController;
