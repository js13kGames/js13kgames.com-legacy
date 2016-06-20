'use strict';

var express = require('express');
var hbs = require('express-hbs');
var sqlite3 = require('sqlite3').verbose();

// Controllers
var homeController = require('./controllers/home');
var entriesController = require('./controllers/entries');

var app = express();
var db = new sqlite3.Database('production.sqlite');

app.engine('hbs', hbs.express4({
  partialsDir: __dirname + '/views/partials',
  layoutsDir: __dirname + '/views/layouts'
}));
app.set('view engine', 'hbs');
app.set('views', __dirname + '/views');

//js13kgames.com/                         -> index for the current year
//js13kgames.com/submit                   -> form to submit a game. This form must be active active only when the compo is running. It needs authentication
//js13kgames.com/jugde                    -> panel to judge games. This panel must be active active only when the compo is running. It needs authentication
//js13kgames.com/admin                    -> admin panel. It needs super user authentication
//js13kgames.com/myprofile                -> page where users can see their profiles. It needs authentication
//js13kgames.com/users/<id>               -> page where everyone can see a user profile with his/her participation through the years.
//js13kgames.com/entries                  -> list of entries for the current year
//js13kgames.com/<year>/entries           -> list of entries for the given year
//js13kgames.com/<year>/entries/<slug>    -> details of the entry for the given year
//js13kgames.com/winners                  -> list of winners for the current year
//js13kgames.com/<year>/winners           -> list of winners for the given year
//js13kgames.com/<year>                   -> index page for the given year

// Routes
app.get('/', homeController);
app.get('/:year', homeController);
app.get('/entries', entriesController);
app.get('/entries/:year', entriesController);

app.listen(3000, function() {
  console.log('Listening on port 3000');
});
