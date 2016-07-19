var baseUrl = "";
var page = 2;
var async = new Async();
var config = new Configuration();

$(document).on("click", "#load-all", function() {
	var resource = $("#show-resource").attr("data-value");
	var endpoint = config.getBaseUrl() + "show/episodes/paged/"+resource+"/"+page;
	var preloader = "&nbsp;&nbsp;" + config.getMiniPreloader(); 
	
	$("td:last").append(preloader);
	async.sendRequest(endpoint, "GET", function(result) {
		$("#loader-mini").remove();
		$("tr:last").before(result);
		page++;
	}, 
	function(err) {
		console.log(err.status + " " + err.statusText);
	});
});