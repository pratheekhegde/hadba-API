'use strict';

module.exports = function(app, cb) {
  var Subject = app.models.subject;

  //MongoDB automigration and collection initialization
  app.dataSources.hadbaMongo.automigrate('subject', function(err) {
    if (err) throw err;

    var year1 = require('./data/subjects/1st-year.json');
    var cs = require('./data/subjects/cs.json');
    var ec = require('./data/subjects/ec.json');
    var cv = require('./data/subjects/cv.json');
    var me = require('./data/subjects/me.json');

    //Creating Subject Data
    Subject.create(year1);
    Subject.create(cs);
    Subject.create(ec);
    Subject.create(ec);
    Subject.create(me);
    process.nextTick(cb);
    console.info('[Boot] - Loaded Subjects data to DB');
  });
};
