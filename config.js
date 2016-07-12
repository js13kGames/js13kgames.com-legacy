var config = {
  db: {
    name: 'main',
    connection: {
      dialect: 'sqlite',
      storage: 'production.sqlite'
    }
  },
  app: {
    name: "js13kgames",
    //domain: 'http://js13kgames.com'
    domain: 'http://localhost:3000'
  },
  games: {
    editionId: 5,
    serverCategoryId: 10,
    maxSize: 13312 // 13kb
  },
  images: {
    maxSize: 102400 // 100kb
  },
  admin: {
    judgeLevel: 10,
    superUserLevel: 100
  }
};

module.exports = config;
