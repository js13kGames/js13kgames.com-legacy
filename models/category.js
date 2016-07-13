var config = require('../config');
var Sequelize = require('sequelize');
var sequelize = new Sequelize(config.db.name, null, null, config.db.connection);

var Edition = require('./edition');

var Category = sequelize.define('category', {
  id: {
    type: Sequelize.INTEGER,
    autoIncrement: true,
    primaryKey: true
  },
  title: Sequelize.STRING,
}, {
  timestamps: false,
  underscored: true,
  classMethods: {
    getBySubmission: function(submissionSlug) {
      return sequelize.query("SELECT cs.category_id, c.title FROM category_submission cs, categories c, submissions s WHERE cs.submission_id = s.id AND cs.category_id = c.id AND s.slug = ?", {
        replacements: [submissionSlug],
        type: sequelize.QueryTypes.SELECT
      })
    }
  }
});

Category.belongsTo(Edition);

module.exports = Category;
