'use strict';

module.exports = function(Subject) {
  // disable Server Sent Events
  Subject.disableRemoteMethod('createChangeStream', true);
};
