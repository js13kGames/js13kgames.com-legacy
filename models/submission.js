var config = require('../config');
var messages= require('../messages');
var Sequelize = require('sequelize');
var sequelize = new Sequelize(config.db.name, null, null, config.db.connection);

var Edition = require('./edition');
// Remaining Validations
// 1. Anti spam, required, valid
// 3. csrf
// 7. website url
// 9. server url (if server)
// 12. file_server zip, max 13kb, if server

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
  categories: {
    type: Sequelize.VIRTUAL,
    set: function(val) {
      this.setDataValue('categories', val);
    },
    allowNull: false
  },
  email: {
    type: Sequelize.STRING,
    allowNull: false,
    validate: { isEmail: true }
  },
  twitter: {
    type: Sequelize.STRING,
    validate: { min: 3 }
  },
  websiteUrl: {
    type: Sequelize.STRING,
    field: "website_url",
    validate: { isUrl: true }
  },
  githubUrl: {
    type: Sequelize.STRING,
    field: "github_url",
    allowNull: false,
    validate: { isUrl: true }
  },
  serverUrl: {
    type: Sequelize.STRING,
    field: "server_url",
    validate: { isUrl: true }
  },
  description: {
    type: Sequelize.TEXT,
    allowNull: false
  },
  title: {
    type: Sequelize.STRING,
    allowNull: false,
    validate: { min: 10 }
  },
  editionId: {
    type: Sequelize.INTEGER,
    allowNull: false,
    validate: { isInt: true }
  },
  score: {
    type: Sequelize.INTEGER,
    validate: { isInt: true }
  },
  fileZip: {
    type: Sequelize.VIRTUAL,
    allowNull: false
  },
  smallScreenshot: {
    type: Sequelize.VIRTUAL,
    allowNull: false
  },
  bigScreenshot: {
    type: Sequelize.VIRTUAL,
    allowNull: false
  }
}, {
  timestamps: true,
  createdAt: 'created_at',
  updatedAt: 'updated_at',
  validate: {
    screenshots: function() {
      isImageValid(this.smallScreenshot);
      isImageValid(this.bigScreenshot);
    },
    zip: function() {
      if (this.fileZip.headers['content-type'] !== 'application/zip') {
        throw new Error(messages.error.invalidZipFormat);
      }
      if (this.fileZip.size > config.games.maxSize) {
        throw new Error(messages.error.invalidZipSize);
      }
    }
  }
});

Submission.belongsTo(Edition);
//Submission.sync();

var isImageValid = function(image) {
  var mimeTypes = ['image/png', 'image/jpeg', 'image/gif'];
  if (mimeTypes.indexOf(image.headers['content-type']) < 0) {
    throw new Error(messages.error.invalidImageFormat);
  }
  if (image.size > config.images.maxSize) {
    throw new Error(messages.error.invalidImageSize);
  }
};

module.exports = Submission;
