'use strict';

module.exports = function(Meta) {
  // disable Server Sent Events
  Meta.disableRemoteMethod('createChangeStream', true);
};
