var Sequelize = require('sequelize');
var sequelize = new Sequelize('main', null, null, {
  dialect: 'sqlite',
  storage: 'production.sqlite'
});

var Edition = sequelize.define('edition', {
  id: {
    type: Sequelize.INTEGER,
    primaryKey: true
  },
  title: Sequelize.STRING,
  slug: Sequelize.STRING
}, {
  timestamps: false
});

module.exports = Edition;
