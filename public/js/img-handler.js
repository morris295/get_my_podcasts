var config = new Configuration();
var async = new Async();

var missimgImageHandler = function(event) {
	var endpoint = config.getBaseUrl() + 'artwork/refresh/'
			+ $(event.target).attr('data-value');

	async.sendRequest(endpoint, "GET").success(function(result) {
		var data = result;
		$(event.target).attr('src', data.image);
	}).fail(function(result) {
		console.log("ID " + $(event.target).attr('data-value') + ": " + result.responseJSON.code + " " + result.responseJSON.message);
	});
}

$(document).ready(function() {
	$("img").on("error", missimgImageHandler);
});

$(document).ajaxComplete(function() {
	$("img").on("error", missimgImageHandler);
});
