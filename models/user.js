var config = require('../config');
var Sequelize = require('sequelize');
var sequelize = new Sequelize(config.db.name, null, null, config.db.connection);

var User = sequelize.define('user', {
  id: {
    type: Sequelize.INTEGER,
    primaryKey: true
  },
  email: {
    type: Sequelize.STRING,
    allowNull: false,
    validate: { isEmail: true }
  },
  password: {
    type: Sequelize.STRING,
    allowNull: false,
    validate: { min: 4 }
  },
  name: {
    type: Sequelize.STRING,
    allowNull: false,
    validate: { min: 4 }
  },
  surname: {
    type: Sequelize.STRING,
    allowNull: false,
    validate: { min: 4 }
  },
  level: {
    type: Sequelize.INTEGER,
    defaultValue: 0
  }
}, {
  timestamps: true,
  createdAt: 'created_at',
  updatedAt: 'updated_at'
});

module.exports = User;
