var Async = function() {
	console.log("New Async instance created.");
};

Async.prototype.sendRequest = function(endpoint, method) {
	var deferred = $.ajax({
		url : endpoint,
		method : method
	});
	return deferred;
};