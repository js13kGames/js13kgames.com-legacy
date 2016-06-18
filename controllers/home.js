var HomeController = function(req, res) {
  var arg;
  var year = req.params.year || '2016';
  if (year === '2016') {
    arg = {is2016: true};
  } else if (year === '2015') {
    arg = {is2015: true};
  } else if (year === '2014') {
    arg = {is2014: true};
  }
  res.render('home', arg);
  //db.all('SELECT * FROM editions', function(err, rows) {
  //  rows.forEach(function(row) {
  //    console.log(row.id + " - " + row.title);
  //  });
  //  res.render('home', {is2015: true});
  //});
};

module.exports = HomeController;
