var HomeController = function(req, res) {
  var arg = {
    is2016: (req.params.year === '2016'),
    is2015: (req.params.year === '2015'),
    is2014: (req.params.year === '2014')
  };
  res.render('home', arg);
};

module.exports = HomeController;
