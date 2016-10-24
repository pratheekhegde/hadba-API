'use strict';

module.exports = function(app, cb) {
  console.info('[Boot] - Setting up Admin account');
  var User = app.models.User;
  var Role = app.models.Role;
  var RoleMapping = app.models.RoleMapping;

  //MongoDB automigration and collection initialization
  app.dataSources.hadbaMongo.automigrate('User', function(err) {
    if (err) throw err;

    User.create([{
      username: 'ptk',
      email: 'ptk609@gmail.com',
      password: 'ptk',
    }], function(err, users) {
      if (err) throw err;
      console.log('* Created users:', users[0].username);

      Role.create({
        name: 'admin',
      }, function(err, role) {
        if (err) throw err;
        console.log('* Created role:', role.name);

        // Make ptk an admin
        role.principals.create({
          principalType: RoleMapping.USER,
          principalId: users[0].id,
        }, function(err, principal) {
          if (err) throw err;
          console.log('* Created principal:', principal.principalType);
        });
      });
    });
  });
  process.nextTick(cb);
};
