var baseUrl = config.getBaseUrl();

$(document).ready(function() {
	setTimeout(function() {
		var indexEndpoint = baseUrl + "index/content";

		loader.run();
		asynch.sendRequest(indexEndpoint, "GET").success(function(result) {
			$("#main-content-wrap").empty();
			$("#main-content-wrap").append(result);
			
			setTimeout(function() {
				loader.stop();
			}, 2500);
		}).error(function(err) {
			$("#main-content-wrap").empty();
			$("#main-content-wrap").append(err.responseText);
			console.log(err.status + " " + err.statusText);
		});
	}, 500);
	
	$(document).on("click", "[id^=play-button-]", function(event) {
		var podcastId = $(event.target).closest('a').attr("data-value");
		var endpoint = baseUrl + "show/episodes/latest/" + podcastId;
		asynch.sendRequest(endpoint, "GET")
			.success(function(result) {
				var item = JSON.parse(result);
				myPlaylist.add({
					title: item.episode.title,
					artist: item.showTitle,
					mp3: item.episode.source,
					poster: ""
				});
				
				myPlaylist.play();
			}).error(function(err) {
				console.log(err);
			});
	});
	
	$(document).on("click", "#pl-add-all-episodes", function(event) {
		
		var episodeCount =
			$($($(event.target).closest(".pos-rlt")[0]).find("#episode-count")[0]).text();
		
		if (parseInt(episodeCount) > 50) {
			alertify.confirm("This podcast has a large number of episodes, would you like to visit the show page?", function (e) {
			    if (e) {
			    	var resource = $(event.target).closest("a").attr("data-value"),
			    	url = baseUrl + "shows/" + resource;
			    	window.location.replace(url);
			    } else {
			    }
			});
		} else {
			var endpoint = baseUrl + "show/episodes/" +
			$(event.target).closest("a").attr("data-value"); 
			asynch.sendRequest(endpoint, "GET")
        		.success(function(result) {
        			var items = JSON.parse(result);
        			items.data.reverse();
        			items.data.forEach(function(item) {
        				myPlaylist.add({
        					title: item.title,
        					artist: "",
        					mp3: item.source,
        					poster: ""
        				});
        			});
        			// Episodes are added in descending date order,
        			// reorder the list to be chronological.
        		})
        		.error(function(result) {
        			console.log(result);
        		});
		}
	});
});
