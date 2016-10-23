'use strict';

module.exports = function(app) {
  var Department = app.models.department;

  //MongoDB automigration and collection initialization
  app.dataSources.hadbaMongo.automigrate('department', function(err) {
    if (err) throw err;

    var departments = require('./data/departments.json');

    //Creating Department Data
    Department.create(departments);
    console.info('[Boot] - Loaded Department data to DB');
  });
};
