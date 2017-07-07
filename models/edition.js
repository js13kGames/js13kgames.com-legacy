var config = require('../config');
var Sequelize = require('sequelize');
var sequelize = new Sequelize(config.db.name, null, null, config.db.connection);

var Edition = sequelize.define('edition', {
  id: {
    type: Sequelize.INTEGER,
    autoIncrement: true,
    primaryKey: true
  },
  title: Sequelize.STRING,
  slug: Sequelize.STRING,
  theme: Sequelize.STRING,
  active: Sequelize.BOOLEAN
}, {
  timestamps: false,
  classMethods: {
    closeAll: function() {
      return sequelize.query("UPDATE editions SET active = 0")
      .spread(function() {
        return Promise.resolve(true);
      })
    }
  }
});



module.exports = Edition;
