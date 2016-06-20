var Entry = require('../models/entry');

var EntriesController = function(req, res) {
  var a = Entry.findAllByYear(req.params.year)
  .then(function(rows) {
    console.log(rows);
    res.render('entries', {entries: rows});
  });
};

module.exports = EntriesController;
