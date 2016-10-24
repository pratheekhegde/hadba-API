'use strict';

module.exports = function(Faculty) {
  // disable Server Sent Events
  Faculty.disableRemoteMethod('createChangeStream', true);
};
