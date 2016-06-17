'use strict';

var express = require('express');
var sqlite3 = require('sqlite3').verbose();

var app = express();
var db = new sqlite3.Database('production.sqlite');

app.get('/', function(req, res) {
  db.all('SELECT * FROM editions', function(err, rows) {
    rows.forEach(function(row) {
      console.log(row.id + " - " + row.title);
    });
    res.send('ok');
  });
});

app.listen(3000, function() {
  console.log('Listening on port 3000');
});
