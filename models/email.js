var fs = require('fs');
var handlebars = require('handlebars');
var nodemailer = require('nodemailer');
var textversionjs = require('textversionjs');

var config = require('../config');

var transporter = nodemailer.createTransport({
  host: config.mailing.host,
  port: config.mailing.port,
  secure: config.mailing.secure,
  auth: {
    user: config.mailing.user,
    password: config.mailing.password
  }
});

var Email = (function() {
  var templates = {
    acceptance: handlebars.compile(fs.readFileSync('./views/emails/submission_accepted.hbs').toString()),
    rejection: handlebars.compile(fs.readFileSync('./views/emails/submission_rejected.hbs').toString()),
    test: handlebars.compile(fs.readFileSync('./views/emails/test.hbs').toString())
  };

  var sendMessage = function(title, template, entry) {
    return new Promise(function(resolve, reject) {
      var htmlBody = template(entry);

      var mailOptions = {
        from: config.mailing.user,
        to: entry.email,
        subject: title,
        text: textversionjs(htmlBody),
        html: htmlBody
      };

      transporter.sendMail(mailOptions, function(err, info) {
        if (err) {
          reject(err);
        } else {
          resolve(true);
        }
      });
    });
  };

  return {
    sendAcceptanceMessage: function(entry) {
      return sendMessage('[js13kgames] Your submission has been accepted', templates.acceptance, entry);
    },
    sendRejectionMessage: function(entry) {
      return sendMessage('[js13kgames] Your submission has been rejected', templates.rejection, entry);
    },
    testMessage: function(entry) {
      return sendMessage('[js13kgames] This is a test', templates.test, entry);
    }
  }
})();

module.exports = Email;
