'use strict';

module.exports = {
  up: function (queryInterface, Sequelize) {
    return queryInterface.createTable('criterion_editions', {
      id: {
        type: Sequelize.INTEGER,
        primaryKey: true,
        autoIncrement: true
      },
      criterion_id: {
        type: Sequelize.INTEGER,
        references: {
          model: 'criteria',
          key: 'id'
        },
        onUpdate: 'cascade',
        onDelete: 'cascade'
      },
      edition_id: {
        type: Sequelize.INTEGER,
        references: {
          model: 'editions',
          key: 'id'
        },
        onUpdate: 'cascade',
        onDelete: 'cascade'
      },
      score: {
        type: Sequelize.INTEGER,
        defaultValue: 10,
        allowNull: false
      },
      created_at: {
        type: Sequelize.DATE
      },
      updated_at: {
        type: Sequelize.DATE
      }
    });
  },

  down: function (queryInterface, Sequelize) {
    return queryInterface.dropTable('criterion_editions');
  }
};
