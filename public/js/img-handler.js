var config = new Configuration();
var async = new Async();

$(document).ajaxComplete(function() {
	$("img").on("error", function(event) {
		var endpoint = config.getBaseUrl() + 'artwork/refresh/' + $(event.target).attr('data-value');
		
		async.sendRequest(endpoint, "GET").success(function(result) {
			var data = JSON.parse(result);
			$(event.target).attr('src', data.image);
		})
		.error(function(err) {
			console.log(err.status + " " + err.statusText);
		});
	});
})