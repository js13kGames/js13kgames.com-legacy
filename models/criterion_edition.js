var config = require('../config');
var Sequelize = require('sequelize');
var sequelize = new Sequelize(config.db.name, null, null, config.db.connection);

var Edition = require('./edition');
var Criterion = require('./criterion');

var CriterionEdition = sequelize.define('criterion_editions', {
  id: {
    type: Sequelize.INTEGER,
    autoIncrement: true,
    primaryKey: true
  },
  edition_id: {
    type: Sequelize.INTEGER,
    references: {
      model: Edition,
      key: 'id'
    }
  },
  criterion_id: {
    type: Sequelize.INTEGER,
    references: {
      model: Criterion,
      key: 'id'
    }
  },
  score: Sequelize.INTEGER,
  multiplier: Sequelize.INTEGER
}, {
  timestamps: true,
  underscored: true
});

CriterionEdition.belongsTo(Edition);
CriterionEdition.belongsTo(Criterion);

module.exports = CriterionEdition;
