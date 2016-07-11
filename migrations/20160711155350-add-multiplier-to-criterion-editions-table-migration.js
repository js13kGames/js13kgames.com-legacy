'use strict';

module.exports = {
  up: function (queryInterface, Sequelize) {
    return queryInterface.addColumn('criterion_editions', 'multiplier', {
      type: Sequelize.INTEGER,
      defaultValue: 1
    });
  },

  down: function (queryInterface, Sequelize) {
    return queryInterface.removeColumn('criterion_editions', 'multiplier');
  }
};
