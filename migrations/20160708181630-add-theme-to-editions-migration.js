'use strict';

module.exports = {
  up: function (queryInterface, Sequelize) {
    return queryInterface.addColumn('editions', 'theme', Sequelize.STRING).then(function() {
      queryInterface.sequelize.query('UPDATE "main"."editions" SET "theme" = "Number 13" WHERE "slug" = 2012');
      queryInterface.sequelize.query('UPDATE "main"."editions" SET "theme" = "Bad Luck" WHERE "slug" = 2013');
      queryInterface.sequelize.query('UPDATE "main"."editions" SET "theme" = "The Elements: Earth, Water, Air and Fire" WHERE "slug" = 2014');
      queryInterface.sequelize.query('UPDATE "main"."editions" SET "theme" = "Reversed" WHERE "slug" = 2015');
    });
  },

  down: function (queryInterface, Sequelize) {
    return queryInterface.removeColumn('editions', 'theme');
  }
};
