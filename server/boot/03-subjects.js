'use strict';

module.exports = function(app) {
  var Subject = app.models.subject;

  //MongoDB automigration and collection initialization
  app.dataSources.hadbaMongo.automigrate('subject', function(err) {
    if (err) throw err;

    var cs = require('./data/subjects/cs.json');
    var ec = require('./data/subjects/ec.json');
    var cv = require('./data/subjects/cv.json');
    var me = require('./data/subjects/me.json');

    //Creating Subject Data
    Subject.create(cs);
    Subject.create(ec);
    Subject.create(ec);
    Subject.create(me);
    console.info('[Boot] - Loaded Subjects data to DB');
  });
};
