'use strict';

module.exports = function(Mapping) {
  // disable Server Sent Events
  Mapping.disableRemoteMethod('createChangeStream', true);
};
