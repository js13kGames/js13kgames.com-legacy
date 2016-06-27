var Submission = require('../models/submission');
var Edition = require('../models/edition');

var EntriesController = function(req, res) {
  var a = Submission.findAll({
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
