var config = require('../config');
var Sequelize = require('sequelize');
var sequelize = new Sequelize(config.db.name, null, null, config.db.connection);

var User = require('./user');
var Submission = require('./submission');
var CriterionEdition = require('./criterion_edition');

var Vote = sequelize.define('votes', {
  id: {
    type: Sequelize.INTEGER,
    primaryKey: true
  },
  user_id: {
    type: Sequelize.INTEGER,
    references: {
      model: User,
      key: 'id'
    }
  },
  submission_id: {
    type: Sequelize.INTEGER,
    references: {
      model: Submission,
      key: 'id'
    }
  },
  criterion_edition_id: {
    type: Sequelize.INTEGER,
    references: {
      model: CriterionEdition,
      key: 'id'
    }
  },
  value: Sequelize.INTEGER
}, {
  timestamps: true,
  underscored: true
});

Vote.belongsTo(User);
Vote.belongsTo(Submission);
Vote.belongsTo(CriterionEdition);

module.exports = Vote;
