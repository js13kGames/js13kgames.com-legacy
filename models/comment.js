var config = require('../config');
var Sequelize = require('sequelize');
var sequelize = new Sequelize(config.db.name, null, null, config.db.connection);

var User = require('./user');
var Submission = require('./submission');

var Comment = sequelize.define('comments', {
  id: {
    type: Sequelize.INTEGER,
    primaryKey: true
  },
  text: Sequelize.TEXT,
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
  }
}, {
  timestamps: true,
  underscored: true
});

Comment.belongsTo(User);
Comment.belongsTo(Submission);

module.exports = Comment;
