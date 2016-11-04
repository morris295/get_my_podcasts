var async = new Async();
var config = new Configuration();

var buildPlayButton = function(attr) {
	var playButton = document.createElement('span');
	var playAnchor = document.createElement('a');
	var wrap = document.createElement('p');
	
	
	playButton.setAttribute('id','play-episode-'+attr.episode_num);
	playButton.setAttribute('data-value', attr.source);
	playButton.setAttribute('data-episodetitle', attr.title);
	playButton.setAttribute('class', 'glyphicon glyphicon-play');
	playAnchor.setAttribute('href', '#/');
	playAnchor.appendChild(playButton);
	wrap.appendChild(playAnchor);
	
	return $(wrap).html();
}

$(document).ready(function() {
	$("#show-content-wrap").append(config.getPreloader());
	var resource = $("#show-resource").attr("data-value");
	var baseUrl = config.getBaseUrl();
	var page = 0;

	var showEndpoint = baseUrl + "show/get/" + resource;
	setTimeout(function() {
		async.sendRequest(showEndpoint, "GET").success(function(result) {
			$("#show-content-wrap").empty();
			$("#show-content-wrap").append(result);
			
			var epTable = $("#episode-table").DataTable({
				"paging": true,
				"ordering": false,
				"searching": false,
				"bLengthChange": false
			});
			
			var resource = $("#show-resource").attr("data-value");
			var endpoint = baseUrl + "show/episodes/" + resource;

			// Update podcast episode back catalogue.
			async.sendRequest(endpoint, "GET").success(function(response) {
				var result = JSON.parse(response);
				epTable.clear();
				$.each(result.data, function(key, item) {
					epTable.row.add(
						[ item.title,
			              item.published,
			              item.length,
			              buildPlayButton(item),
			              item.episode_num,
		                ]).draw(false);
				});
			});
			
		}).error(function(err) {
			console.log(err.status + " " + err.statusText);
			$("#show-content-wrap").empty();
			$("#show-content-wrap").append(err.responseText);
		});
	}, 500);
});