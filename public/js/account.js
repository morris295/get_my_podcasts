var baseUrl = config.getBaseUrl();
loader.run();

$(document).ready(function() {
	setTimeout(function() { loader.stop(); }, 2500);

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
	
	$("#play-all-following").click(function() {
		
		var episodes = $("[id^=episode-");
		
		$.each(episodes, function(key, value) {
			myPlaylist.add({
				title: $(value).text(),
				artist: "",
				mp3: $(value).attr('data-value'),
				poster: ""
			});
			
			myPlaylist.play();
		});
	});
	
	$("[id^=play-latest-").click(function(event) {
		var link = $(event.target).closest("a");
		myPlaylist.add({
			title: $(link).attr("data-info"),
			artist: "",
			mp3: $(link).attr("data-value"),
			poster: ""
		});
		
		myPlaylist.play();
	});
});