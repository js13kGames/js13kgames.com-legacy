var config = require('../config');
var Sequelize = require('sequelize');
var sequelize = new Sequelize(config.db.name, null, null, config.db.connection);

var Edition = require('./edition');

var Category = sequelize.define('category', {
  id: {
    type: Sequelize.INTEGER,
    primaryKey: true
  },
  title: Sequelize.STRING,
}, {
  timestamps: false,
  underscored: true
});

Category.belongsTo(Edition);

module.exports = Category;
