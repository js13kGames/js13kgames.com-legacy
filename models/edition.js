var config = require('../config');
var Sequelize = require('sequelize');
var sequelize = new Sequelize(config.db.name, null, null, config.db.connection);

var Edition = sequelize.define('edition', {
  id: {
    type: Sequelize.INTEGER,
    primaryKey: true
  },
  title: Sequelize.STRING,
  slug: Sequelize.STRING,
  theme: Sequelize.STRING
}, {
  timestamps: false
});

module.exports = Edition;
