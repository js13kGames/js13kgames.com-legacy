var config = {
  db: {
    name: 'main',
    connection: {
      dialect: 'sqlite',
      storage: 'production.sqlite'
    }
  },
  app: {
    domain: 'http://js13kgames.com'
  },
  games: {
    editionId: 5,
    serverCategoryId: 10,
    maxSize: 13312 // 13kb
  },
  images: {
    maxSize: 102400 // 100kb
  }
};

module.exports = config;
