var EntriesController = function(req, res) {
  // FIXME: Use the current year instead of hardcoding 2016
  var year = req.params.year || '2016';
  res.render('entries');
};

module.exports = EntriesController;
