var sqlite3 = require('sqlite3').verbose();
var db = new sqlite3.Database('production.sqlite');

var Entry = function(obj){
  // TODO: Check if we can omit all of these values (validating later)
  this.id = obj.id || null;
  this.active = obj.active || 1;
  this.slug = obj.slug || null;
  this.author = obj.author || null;
  this.email = obj.email || null;
  this.twitter = obj.twitter || '';
  this.websiteUrl = obj.website_url;
  this.githubUrl = obj.github_url || null;
  this.serverUrl = obj.server_url || null;
  this.description = obj.description || null;
  this.title = obj.title || null;
  this.editionId = obj.edition_id || null;
  this.createdAt = obj.created_at || '';
  this.updatedAt = obj.updated_at || '';
  this.score = obj.score || null;
};

Entry.prototype.constructor = Entry;

var _find = function(sql) {
  var results = [];
  console.log('[SQLITE]', sql);
  return new Promise(function(resolve, reject) {
    db.all(sql, function(err, rows) {
      if (err) reject(err);
      rows.forEach(function(row) {
        results.push(new Entry(row));
      })
      resolve(results);
    });
  });
};

Entry.findAll = function() {
  return _find('SELECT * FROM submissions');
};

Entry.findAllByYear = function(year) {
  console.log('year', year);
  // TODO: Sanitize year
  return _find('SELECT s.* FROM submissions s, editions e WHERE s.edition_id = e.id AND e.slug = "' + year +'"');
};

module.exports = Entry;
