'use strict';

module.exports = {
  up: function (queryInterface, Sequelize) {
    return queryInterface.addColumn('votes', 'criterion_edition_id', {
      type: Sequelize.INTEGER,
      references: {
        model: 'criterion_editions',
        key: 'id'
      }
    });
  },

  down: function (queryInterface, Sequelize) {
    return queryInterface.removeColumn('votes', 'criterion_edition_id');
  }
};
