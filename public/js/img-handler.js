var missimgImageHandler = function(event) {
	var resource = $(event.target).attr('data-value');

	if (resource !== undefined) {
		var endpoint = config.getBaseUrl() + 'artwork/refresh/'+resource; 

		asynch.sendRequest(endpoint, "GET").success(function(result) {
			var data = result;
			$(event.target).attr('src', data.image);
		}).error(function(result) {
			$(event.target).attr('src', config.getBaseUrl() + 'image/play.png');
		});
	}
}

$(document).ready(function() {
	$("img").on("error", missimgImageHandler);
});

$(document).ajaxComplete(function() {
	$("img").on("error", missimgImageHandler);
});
