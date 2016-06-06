$(document).ready(function() {
	
	var baseUrl = "";
	
	if (window.location.host.indexOf('localhost') !== -1) {
		baseUrl = "/get_my_podcasts/public/";
	} else {
		baseUrl = "/";
	}
	
	var preloader = "<div id=\"loader\"><p>Please wait...</p><img src=\""+
		baseUrl+"image/ajax-loader.gif\" /></div>";
		
	
	if ($("#main-content-wrap").length > 0) {
		
		$("#main-content-wrap").append(preloader);
		var indexEndpoint = baseUrl + "index/content";
		
		$.ajax({
			url: indexEndpoint,
			method: "GET"
		}).success(function(content) {
			$("#main-content-wrap").empty();
			$("#main-content-wrap").append(content);
		}).error(function() {
			$("#main-content-wrap").empty();
		});
		
	} else if ($("#show-content-wrap").length > 0) {
		
		$("#show-content-wrap").append(preloader);
		var resource = $("#show-resource").attr("data-value");
		
		var showEndpoint = baseUrl + "show/get/"+resource; 
		
		$.ajax({
			url: showEndpoint,
			method: "GET"
		}).success(function(content) {
			$("#show-content-wrap").empty();
			$("#show-content-wrap").append(content);
		}).error(function(err) {
			console.log(err.status + " " + err.statusText);
			$("#show-content-wrap").empty();
		});
	}
	
	$("[id^=refresh-show-]").click(function() {

		var itemClicked = $(this);
		var value = itemClicked.attr("data-value");
		var resource = itemClicked.attr("data-resource");
		
		var contentElement = $("#show-"+value+"-episode-table-wrap");
		var refreshEndpoint = baseUrl + "subscription/refresh/"+resource;
		
		contentElement.empty();
		contentElement.append(preloader);
		
		$.ajax({
			url: refreshEndpoint,
			method: "GET",
		}).success(function(content) {
			contentElement.empty();
			contentElement.append(content)
		}).error(function(err) {
			contentElement.empty();
			alertify.error("Refreshing episodes failed.");
			console.log(err.status + " " + err.statusText);
		});
	});
});