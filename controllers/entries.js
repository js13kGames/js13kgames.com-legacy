var Sequelize = require('sequelize');
var Entry = require('../models/entry');
var Edition = require('../models/edition');

var EntriesController = function(req, res) {
  var a = Entry.findAll({
    include: [{
      model: Edition,
      where: {
        slug: req.params.year
      }
    }]
  }).then(function(rows) {
    res.render('entries', {entries: rows});
  });
};

module.exports = EntriesController;
