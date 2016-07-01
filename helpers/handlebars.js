var registerHelpers = function (hbs) {
  hbs.registerHelper('eq', function (lvalue, rvalue, options) {
    if (arguments.length < 3) {
      throw new Error('Handlebars Helper "equals" needs 2 parameters');
    }
    if (lvalue !== rvalue) {
      return options.inverse(this);
    } else {
      return options.fn(this);
    }
  });

  hbs.registerHelper('neq', function (lvalue, rvalue, options) {
    if (arguments.length < 3) {
      throw new Error('Handlebars Helper "nequals" needs 2 parameters');
    }
    if (lvalue === rvalue) {
      return options.inverse(this);
    } else {
      return options.fn(this);
    }
  });

  hbs.registerHelper('or', function (lvalue, rvalue, options) {
    if (arguments.length < 3) {
      throw new Error('Handlebars Helper "either" needs 2 parameters');
    }
    if (lvalue || rvalue) {
      return options.fn(this);
    } else {
      return options.inverse(this);
    }
  });

  hbs.registerHelper('gte', function (lvalue, rvalue, options) {
    if (arguments.length < 3) {
      throw new Error('Handlebars Helper "gte" needs 2 parameters');
    }
    if (lvalue >= rvalue) {
      return options.fn(this);
    } else {
      return options.inverse(this);
    }
  });

  hbs.registerHelper('lte', function (lvalue, rvalue, options) {
    if (arguments.length < 3) {
      throw new Error('Handlebars Helper "lte" needs 2 parameters');
    }
    if (lvalue <= rvalue) {
      return options.fn(this);
    } else {
      return options.inverse(this);
    }
  });

  hbs.registerHelper('gt', function (lvalue, rvalue, options) {
    if (arguments.length < 3) {
      throw new Error('Handlebars Helper "gt" needs 2 parameters');
    }
    if (lvalue > rvalue) {
      return options.fn(this);
    } else {
      return options.inverse(this);
    }
  });

  hbs.registerHelper('lt', function (lvalue, rvalue, options) {
    if (arguments.length < 3) {
      throw new Error('Handlebars Helper "lt" needs 2 parameters');
    }
    if (lvalue < rvalue) {
      return options.fn(this);
    } else {
      return options.inverse(this);
    }
  });
};

module.exports = registerHelpers;
