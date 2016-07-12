'use strict';

module.exports = {
  up: function (queryInterface, Sequelize) {
    return queryInterface.addColumn('criteria', 'suggested_multiplier', Sequelize.INTEGER).then(function() {
      queryInterface.sequelize.query('UPDATE "criteria" SET "suggested_multiplier" = "1" WHERE "slug" = "innovation"');
      queryInterface.sequelize.query('UPDATE "criteria" SET "suggested_multiplier" = "1" WHERE "slug" = "fun"');
      queryInterface.sequelize.query('UPDATE "criteria" SET "suggested_multiplier" = "1" WHERE "slug" = "gameplay"');
      queryInterface.sequelize.query('UPDATE "criteria" SET "suggested_multiplier" = "1" WHERE "slug" = "aesthetics"');
      queryInterface.sequelize.query('UPDATE "criteria" SET "suggested_multiplier" = "1" WHERE "slug" = "humor"');
      queryInterface.sequelize.query('UPDATE "criteria" SET "suggested_multiplier" = "1" WHERE "slug" = "narrative"');

      queryInterface.sequelize.query('UPDATE "criteria" SET "suggested_multiplier" = "2" WHERE "slug" = "theme"');
      queryInterface.sequelize.query('UPDATE "criteria" SET "suggested_multiplier" = "2" WHERE "slug" = "technical"');
    });
  },

  down: function (queryInterface, Sequelize) {
    return queryInterface.removeColumn('criteria', 'suggested_multiplier');
  }
};
