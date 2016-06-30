var HomeController = function(req, res) {
  var arg = {
    is2016: (req.params.year === '2016'),
    is2015: (req.params.year === '2015'),
    is2014: (req.params.year === '2014'),
    is2013: (req.params.year === '2013'),
    is2012: (req.params.year === '2012'),
  };

  /*This is needed as before 2016 each page is unique and cannot use layout */
  if(req.params.year === '2016')
  {
    res.render('home', arg);
  } else {
    res.render('homelegacy', arg);
  }
 
};

module.exports = HomeController;
