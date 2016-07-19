var async = new Async();
var config = new Configuration();

var updateEpisodeCatalogue = function(endpoint) {
	
	async.sendRequest(endpoint, function(result) {
		$("tr:last").show();
		var message = JSON.parse(result).message; 
		console.log(message);
	});	
};

$(document).ready(function() {
	$("#show-content-wrap").append(config.getPreloader());
	var resource = $("#show-resource").attr("data-value");
	var baseUrl = config.getBaseUrl();
	
	var showEndpoint = baseUrl + "show/get/"+resource;
	setTimeout(function() {
			async.sendRequest(showEndpoint, "GET",  function(result) {
				$("#show-content-wrap").empty();
				$("#show-content-wrap").append(result);
				$("tr:last").hide();
				var resource = $("#show-resource").attr("data-value");
				var endpoint = baseUrl + "show/episodes/"+resource;
				updateEpisodeCatalogue(endpoint);
			}, 
			function(err) {
				console.log(err.status + " " + err.statusText);
				$("#show-content-wrap").empty();
				$("#show-content-wrap").append(err.responseText);
			});
	}, 500);
});