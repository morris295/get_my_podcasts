var Async = function() {
	console.log("New Async instance created.");
};

Async.prototype.sendRequest = function(endpoint, method, successCallback, failureCallback) {
	var deferred = $.ajax({ url: endpoint, method: method });
	deferred.done(successCallback);
	deferred.fail(failureCallback);
};