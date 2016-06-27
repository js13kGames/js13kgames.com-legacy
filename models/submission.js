var config = require('../config');
var messages= require('../messages');
var Sequelize = require('sequelize');
var sequelize = new Sequelize(config.db.name, null, null, config.db.connection);

var Edition = require('./edition');
// Validations
// 1. Anti spam, required, valid
// 2. Unique and not reserved slug
// 3. csrf
// 4. author, min-3
// 5. email, required
// 6. categories, required
// 7. website url
// 8. github url
// 9. server url (if server)
// 10. title, required, min 10, max 1000
// 11. file zip, max 13kb
// 12. file_server zip, max 13kb, if server
// 13. small_screenshot jpeg, gif, png, max 100kb
// 14. big_screenshot jpeg, gif, png, max 100kb

var Submission = sequelize.define('submission', {
  id: {
    type: Sequelize.INTEGER,
    primaryKey: true
  },
  active: {
    type: Sequelize.BOOLEAN,
    defaultValue: 1
  },
  slug: {
    type: Sequelize.STRING,
    validate: {
      isUnique: function(value, next) {
        Submission.findAll({
          where: { slug: value },
          attributes: ['id']
        })
        .then(function(results) {
          if (results.length > 0) next(messages.error.slugNotUnique);
          next();
        })
        .catch(function(err) {
          next(err);
        })
      }
    }
  },
  author: {
    type: Sequelize.STRING,
    validate: { min: 3 }
  },
  email: {
    type: Sequelize.STRING,
    validate: { isEmail: true }
  },
  twitter: {
    type: Sequelize.STRING,
    validate: { min: 3 }
  },
  website_url: {
    type: Sequelize.STRING,
    validate: { isUrl: true }
  },
  github_url: {
    type: Sequelize.STRING,
    validate: { isUrl: true }
  },
  server_url: {
    type: Sequelize.STRING,
    validate: { isUrl: true }
  },
  description: Sequelize.TEXT,
  title: {
    type: Sequelize.STRING,
    validate: { min: 10 }
  },
  score: {
    type: Sequelize.INTEGER,
    validate: { isInt: true }
  }
}, {
  timestamps: true,
  createdAt: 'created_at',
  updatedAt: 'updated_at',
  underscored: true
});

Submission.belongsTo(Edition);
//Submission.sync();

module.exports = Submission;
