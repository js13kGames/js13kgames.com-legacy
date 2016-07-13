var config = require('../config');
var Sequelize = require('sequelize');
var sequelize = new Sequelize(config.db.name, null, null, config.db.connection);

var User = require('./user');
var Submission = require('./submission');
var CriterionEdition = require('./criterion_edition');

var Vote = sequelize.define('votes', {
  id: {
    type: Sequelize.INTEGER,
    autoIncrement: true,
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
  underscored: true,
  classMethods: {
    getByUser: function(submissionSlug) {
      return sequelize.query("SELECT v.id, v.user_id, u.name, u.surname, SUM(v.value) as score FROM votes AS v  INNER JOIN submissions AS s ON v.submission_id = s.id LEFT OUTER JOIN users AS u ON v.user_id = u.id WHERE s.slug = ? GROUP BY v.user_id ORDER BY score DESC", {
        replacements: [submissionSlug],
        type: sequelize.QueryTypes.SELECT
      })
    }
  }
});

Vote.belongsTo(User);
Vote.belongsTo(Submission);
Vote.belongsTo(CriterionEdition);

module.exports = Vote;
