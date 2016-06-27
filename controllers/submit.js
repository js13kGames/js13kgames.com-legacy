var Category = require('../models/category');
var Edition = require('../models/edition');

var SubmitController = {};

SubmitController.get = function(req, res) {
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

SubmitController.post = function(req, res) {
  console.log('asdasd', req.body);
  res.render('submit', {categories: [], csrf: '1234567890'});
};

module.exports = SubmitController;
