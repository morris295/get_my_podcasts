var Async = function() {
	console.log("New Async instance created.");
};

Async.prototype.sendRequest = function(endpoint, method, csrfToken, data) {
	
	var deferred;
	
	if (method === "POST") {
		
		deferred = $.ajax({
			url : endpoint,
			method : method,
			data: data,
			headers: {
	            'X-CSRF-TOKEN': csrfToken
	        }
		});
	} else {
		deferred = $.ajax({
			url : endpoint,
			method : method
		});
	}
	
	return deferred;
};