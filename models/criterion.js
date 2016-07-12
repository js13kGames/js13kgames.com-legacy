var config = require('../config');
var Sequelize = require('sequelize');
var sequelize = new Sequelize(config.db.name, null, null, config.db.connection);

var Criterion = sequelize.define('criteria', {
  id: {
    type: Sequelize.INTEGER,
    primaryKey: true
  },
  title: Sequelize.STRING,
  slug: Sequelize.STRING,
  title: Sequelize.STRING,
  description: Sequelize.TEXT,
  suggested_multiplier: Sequelize.INTEGER,
  active: Sequelize.BOOLEAN,
}, {
  timestamps: true,
  underscored: true
});

module.exports = Criterion;
