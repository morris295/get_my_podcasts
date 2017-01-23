var buildPlayButton = function(attr) {
	var playButton = document.createElement('span');
	var playAnchor = document.createElement('a');
	var wrap = document.createElement('p');
	
	
	playButton.setAttribute('id','play-episode-'+attr.episode_num);
	playButton.setAttribute('data-value', attr.source);
	playButton.setAttribute('data-episodetitle', attr.title);
	playButton.setAttribute('class', 'icon-control-play');
	playAnchor.setAttribute('href', '#/');
	playAnchor.appendChild(playButton);
	wrap.appendChild(playAnchor);
	
	return $(wrap).html();
}

var buildAddButton = function(attr) {
	var addButton = document.createElement('span');
	var addAnchor = document.createElement('a');
	var wrap = document.createElement('p');
	
	addButton.setAttribute('id','add-to-pl-'+attr.episode_num);
	addButton.setAttribute('data-value', attr.source);
	addButton.setAttribute('data-episodetitle', attr.title);
	addButton.setAttribute('class', 'fa fa-plus-circle');
	addAnchor.setAttribute('href', '#/');
	addAnchor.appendChild(addButton);
	wrap.appendChild(addAnchor);
	
	return $(wrap).html();
}

var getRelatedPodcasts = function(podcastId) {
	
	var endpoint = config.getBaseUrl() + "show/related/" + podcastId;
	
	asynch.sendRequest(endpoint, "GET")
		.success(function(result) {
			for(var i = 0; i < result.length; i++) {
				$("#related_link-"+i).attr("href", config.getBaseUrl() + result[i].resource);
				$("#related_img-"+i).attr("src", result[i].image_url);
				$("#related_title-"+i).text(result[i].title);
			}
		});
}

$(document).ready(function() {
	var resource = $("#show-resource").attr("data-value");
	var baseUrl = config.getBaseUrl();
	var page = 0;

	var showEndpoint = baseUrl + "show/get/" + resource;
	
	loader.run();
	setTimeout(function() {
		asynch.sendRequest(showEndpoint, "GET").success(function(result) {
			$("#show-content-wrap").empty();
			$("#show-content-wrap").append(result);
			var primaryColor = "rgb(" + $("meta[name=primaryColor]").attr("content") + ")";
			var contrastColor = "rgb(" + $("meta[name=contrastColor]").attr("content") + ")";
			var primaryColor = "radial-gradient(transparent, " + primaryColor + ")";
			$(".item.pos-rlt").css('background', primaryColor);
			$("#show-title").css('background', contrastColor);
			
			var epTable = $("#episode-table").DataTable({
				"paging": true,
				"ordering": false,
				"searching": false,
				"bLengthChange": false
			});
			
			var resource = $("#show-resource").attr("data-value");
			var endpoint = baseUrl + "show/episodes/" + resource;

			// Update podcast episode back catalogue.
			asynch.sendRequest(endpoint, "GET").success(function(response) {
				var result = JSON.parse(response);
				epTable.clear();
				$.each(result.data, function(key, item) {
					epTable.row.add(
						[ item.title,
			              item.published,
			              item.length,
			              buildAddButton(item),
			              buildPlayButton(item)
		                ]).draw(false);
					
				});
				loader.stop();
				getRelatedPodcasts(resource);
			});
			
		}).error(function(err) {
			console.log(err.status + " " + err.statusText);
			$("#show-content-wrap").empty();
			$("#show-content-wrap").append(err.responseText);
		});
	}, 500);
});