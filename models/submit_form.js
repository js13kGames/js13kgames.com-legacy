'use strict';

var SubmitForm = function(fields, files) {
  return {
    title: fields.title[0],
    slug: stringToSlug(fields.title[0]),
    author: fields.author[0],
    twitter: fields.twitter[0],
    categories: fields['categories[]'],
    email: fields.email[0],
    websiteUrl: fields.website_url[0],
    githubUrl: fields.github_url[0],
    description: fields.description[0],
    fileZip: files.file[0],
    smallScreenshot: files.small_screenshot[0],
    bigScreenshot: files.big_screenshot[0],
    csrf: fields.csrf[0]
  }
};

SubmitForm.prototype.constructor = SubmitForm;

var stringToSlug = function(value) {
  value = value.toLowerCase();
  value = value.replace(' ', '_');
  return value;
};

module.exports = SubmitForm;
