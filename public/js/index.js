var config = new Configuration();
var baseUrl = config.getBaseUrl();

$(document).ready(function() {
	var async = new Async();

	$("#myCarousel").hide();
	$("#front-search").hide();

	$("#main-content-wrap").append(config.getPreloader());

	setTimeout(function() {
		var indexEndpoint = baseUrl + "index/content";

		async.sendRequest(indexEndpoint, "GET").success(function(result) {
			$("#main-content-wrap").empty();
			$("#main-content-wrap").append(result);

			var carouselItems = $(".item");

			carouselItems.each(function(item) {
				async.sendRequest(baseUrl + "artwork", "GET").success(function(result) {
					data = JSON.parse(result);
					var link = carouselItems[item].children[0];
					link.href = baseUrl + data.resource;
					link.children[0].src = data.image;
					$(link.children[0]).attr('data-value', data.dataValue);
					$("#myCarousel").show();
					$("#front-search").show();
				}).error(function(err) {
					console.log(err.status + " " + err.statusText);
				});
			});
		}).error(function(err) {
			$("#main-content-wrap").empty();
			$("#main-content-wrap").append(err.responseText);
			console.log(err.status + " " + err.statusText);
		});
	}, 500);
});