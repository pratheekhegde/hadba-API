'use strict';

module.exports = function(app) {
  var Faculty = app.models.faculty;

  //MongoDB automigration and collection initialization
  app.dataSources.hadbaMongo.automigrate('faculty', function(err) {
    if (err) throw err;

    var faculties = require('./data/faculties.json');

    //Creating Faculty Data
    Faculty.create(faculties);
    console.info('[Boot] - Loaded Faculties data to DB');
  });
};
