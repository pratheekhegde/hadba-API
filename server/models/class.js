'use strict';

module.exports = function(Class) {
  // disable Server Sent Events
  Class.disableRemoteMethod('createChangeStream', true);
};
