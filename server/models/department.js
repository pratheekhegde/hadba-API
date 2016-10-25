'use strict';

module.exports = function(Department) {
  // disable Server Sent Events
  Department.disableRemoteMethod('createChangeStream', true);
};
