'use strict';

module.exports = function(app) {
  var Subject = app.models.subject;

  //MongoDB automigration and collection initialization
  app.dataSources.hadbaMongo.automigrate('subject', function(err) {
    if (err) throw err;

    var cs = require('./data/subjects/cs.json');

    //Creating Subject Data
    Subject.create(cs);
    console.info('[Boot] - Loaded Subjects data to DB');
  });
};
