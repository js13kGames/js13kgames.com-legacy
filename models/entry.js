var Sequelize = require('sequelize');
var sequelize = new Sequelize('main', null, null, {
  dialect: 'sqlite',
  storage: 'production.sqlite'
});

var Edition = require('./edition');

var Entry = sequelize.define('submission', {
  id: {
    type: Sequelize.INTEGER,
    primaryKey: true
  },
  active: Sequelize.BOOLEAN,
  slug: Sequelize.STRING,
  author: Sequelize.STRING,
  email: Sequelize.STRING,
  twitter: Sequelize.STRING,
  twitter: Sequelize.STRING,
  website_url: Sequelize.STRING,
  github_url: Sequelize.STRING,
  server_url: Sequelize.STRING,
  description: Sequelize.TEXT,
  title: Sequelize.STRING,
  score: Sequelize.INTEGER
}, {
  timestamps: true,
  createdAt: 'created_at',
  updatedAt: 'updated_at',
  underscored: true
});

Entry.belongsTo(Edition);

module.exports = Entry;
