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
    }, {
      username: 'guest',
      email: 'guest@guest.com',
      password: 'guest',
    }], function(err, users) {
      if (err) throw err;
      console.log('* Created users:', users[0].username);
      console.log('* Created users:', users[1].username);

      // create admin user
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

      // create guest user
      Role.create({
        name: 'guest',
      }, function(err, role) {
        if (err) throw err;
        console.log('* Created role:', role.name);

        // Make ptk an admin
        role.principals.create({
          principalType: RoleMapping.USER,
          principalId: users[1].id,
        }, function(err, principal) {
          if (err) throw err;
          console.log('* Created principal:', principal.principalType);
        });
      });
    });
  });
  process.nextTick(cb);
};
