'use strict';

module.exports = {
  up: function (queryInterface, Sequelize) {
    return queryInterface.createTable('criteria', {
      id: {
        type: Sequelize.INTEGER,
        primaryKey: true,
        autoIncrement: true
      },
      slug: {
        type: Sequelize.STRING,
        allowNull: false
      },
      title: {
        type: Sequelize.STRING,
        allowNull: false
      },
      description: {
        type: Sequelize.TEXT,
        allowNull: false
      },
      active: {
        type: Sequelize.BOOLEAN,
        defaultValue: 0
      },
      created_at: {
        type: Sequelize.DATE
      },
      updated_at: {
        type: Sequelize.DATE
      }
    }).then(function() {
      queryInterface.sequelize.query('INSERT INTO "criteria" (slug, title, description, active, created_at, updated_at) ' +
                                     'VALUES ("innovation", "Innovation", "Original idea, things in a unique combination, or something so different that it\'s notable.", 1, datetime("now"), datetime("now"))');
      queryInterface.sequelize.query('INSERT INTO "criteria" (slug, title, description, active, created_at, updated_at) ' +
                                     'VALUES ("fun", "Fun", "How much did you enjoy playing the game? Did you play for hours and you even noticed? Or maybe you just played a couple of minutes but would like to play it for hours.", 1, datetime("now"), datetime("now"))');
      queryInterface.sequelize.query('INSERT INTO "criteria" (slug, title, description, active, created_at, updated_at) ' +
                                     'VALUES ("theme", "Theme", "How well the entry suits the theme? Is the theme being used in the game in any way?", 1, datetime("now"), datetime("now"))');
      queryInterface.sequelize.query('INSERT INTO "criteria" (slug, title, description, active, created_at, updated_at) ' +
                                     'VALUES ("gameplay", "Gameplay", "This considers the manner in which players interact with the game. Not only the effectiveness of the interface and simplicity of controls, but also interactions between characters and environment, as well as the variety of actions, collectibles, and missions.", 1, datetime("now"), datetime("now"))');
      queryInterface.sequelize.query('INSERT INTO "criteria" (slug, title, description, active, created_at, updated_at) ' +
                                     'VALUES ("aesthetics", "Aesthetics", "This covers how good the game looks or how effective the visual style is. Think about design, graphics, mood, the vibe you get while playing.", 1, datetime("now"), datetime("now"))');
      queryInterface.sequelize.query('INSERT INTO "criteria" (slug, title, description, active, created_at, updated_at) ' +
                                     'VALUES ("humor", "Humor", "Consider how amusing the game is. Is it funny? Does it contain humorous dialog or funny stuff?", 1, datetime("now"), datetime("now"))');
      queryInterface.sequelize.query('INSERT INTO "criteria" (slug, title, description, active, created_at, updated_at) ' +
                                     'VALUES ("narrative", "Narrative", "The plot, character of the characters and relationships between them. Storytelling, moral or key message sent to the player while playing the game.", 1, datetime("now"), datetime("now"))');
      queryInterface.sequelize.query('INSERT INTO "criteria" (slug, title, description, active, created_at, updated_at) ' +
                                     'VALUES ("technical", "Technical", "This covers all technical aspects inherent the realization: algorithms (like AI, procedural generation, etc), compression, optimizations, codebase, etc. How well were managed the resources? Images, sounds, text, boilerplate code, etc.", 1, datetime("now"), datetime("now"))');
    });
  },

  down: function (queryInterface, Sequelize) {
    return queryInterface.dropTable('criteria');
  }
};
