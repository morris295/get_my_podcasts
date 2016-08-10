var async = new Async();
var config = new Configuration();
var baseUrl = config.getBaseUrl();

$("[id^=refresh-show-]").click(function() {

	var itemClicked = $(this);
	var value = itemClicked.attr("data-value");
	var resource = itemClicked.attr("data-resource");

	var contentElement = $("#show-" + value + "-episode-wrap");
	var refreshEndpoint = baseUrl + "subscription/refresh/" + resource;

	contentElement.empty();
	contentElement.append(config.getPreloader());

	async.sendRequest(refreshEndpoint, "GET").success(function(result) {
		contentElement.empty();
		contentElement.append(result)
	}).error(function(err) {
		contentElement.empty();
		alertify.error("Refreshing episodes failed.");
		console.log(err.status + " " + err.statusText);
	});
});