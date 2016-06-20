var HomeController = function(req, res) {
  var arg = {
    is2016: (req.params.year === '2016'),
    is2015: (req.params.year === '2015'),
    is2014: (req.params.year === '2014')
  };
  res.render('home', arg);
  //db.all('SELECT * FROM editions', function(err, rows) {
  //  rows.forEach(function(row) {
  //    console.log(row.id + " - " + row.title);
  //  });
  //  res.render('home', {is2015: true});
  //});
};

module.exports = HomeController;
