var baseUrl = "";
var page = 2;
var async = new Async();
var config = new Configuration();

$(document).on("click", "#load-all", function() {
	var resource = $("#show-resource").attr("data-value");
	var endpoint = config.getBaseUrl() + "show/episodes/paged/"+resource+"/"+page;
	preloader = config.getMiniPreloader();
	
	$("td:last").append(preloader);
	async.sendRequest(endpoint, "GET")
	.success(function(result) {
		$("#loader-mini").remove();
		$("tr:last").before(result);
		page++;
	})
	.error(function(err) {
		console.log(err.status + " " + err.statusText);
	});
});