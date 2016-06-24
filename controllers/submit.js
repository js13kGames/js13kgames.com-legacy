var Category = require('../models/category');
var Edition = require('../models/edition');

var SubmitController = function(req, res) {
  var a = Category.findAll({
    include: [{
      model: Edition,
      where: {
        //slug: req.params.year
        slug: 2015
      }
    }]
  }).then(function(rows) {
    res.render('submit', {categories: rows, csrf: '1234567890'});
  });
};

module.exports = SubmitController;
