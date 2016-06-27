'use strict';

var express = require('express');
var hbs = require('express-hbs');

// Controllers
var homeController = require('./controllers/home');
var entriesController = require('./controllers/entries');
var submitController = require('./controllers/submit');

var app = express();

app.engine('hbs', hbs.express4({
  partialsDir: __dirname + '/views/partials',
  layoutsDir: __dirname + '/views/layouts'
}));
app.set('view engine', 'hbs');
app.set('views', __dirname + '/views');
app.use(express.static('public/assets'));

var defaultYear = function(req, res, next){
  req.params.year = req.params.year || '2016';
  next();
};

//js13kgames.com/submit                   -> form to submit a game. This form must be active active only when the compo is running. It needs authentication
//js13kgames.com/jugde                    -> panel to judge games. This panel must be active active only when the compo is running. It needs authentication
//js13kgames.com/admin                    -> admin panel. It needs super user authentication
//js13kgames.com/myprofile                -> page where users can see their profiles. It needs authentication
//js13kgames.com/users/<id>               -> page where everyone can see a user profile with his/her participation through the years.
//js13kgames.com/<year>/entries/<slug>    -> details of the entry for the given year
//js13kgames.com/winners                  -> list of winners for the current year
//js13kgames.com/<year>/winners           -> list of winners for the given year

// Routes
app.get('/submit', defaultYear, submitController.get);
app.post('/submit', defaultYear, submitController.post);
app.get('/:year', defaultYear, homeController);
app.get('/entries', defaultYear, entriesController);
app.get('/:year/entries', defaultYear, entriesController);
app.get('/', defaultYear, homeController);

app.listen(3000, function() {
  console.log('Listening on port 3000');
});
