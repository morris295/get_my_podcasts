var config = new Configuration();
var async = new Async();

var handler = function(event) {
	var endpoint = config.getBaseUrl() + 'artwork/refresh/' + $(event.target).attr('data-value');
	
	async.sendRequest(endpoint, "GET").success(function(result) {
		var data = JSON.parse(result);
		$(event.target).attr('src', data.image);
	})
	.error(function(err) {
		console.log(err.status + " " + err.statusText);
	});
}

$(document).ready(function() {
	$("img").on("error", handler);
});

$(document).ajaxComplete(function() {
	$("img").on("error", handler);
});
