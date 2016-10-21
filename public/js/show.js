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

var updateEpisodeCatalogue = function(endpoint) {
	setTimeout(function() {
		async.sendRequest(endpoint, "GET").success(function(result) {
			$("tr:last").show();
			var message = JSON.parse(result).message;
			console.log(message);
		}).error(function(err) {
			console.log(err.status + " " + err.statusText);
		});
	}, 500);
};

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
			
			async.sendRequest(baseUrl + '/show/episodes/page-count/' + resource, "GET").success(function(result) {
				page = result;
				for (var i = 2; i <= page; i++) {
					resource = $("#show-resource").attr("data-value"),
					endpoint = config.getBaseUrl() + "show/episodes/paged/"+resource+"/"+i;
					
					async.sendRequest(endpoint, "GET")
					.success(function(result) {
						var episodes = JSON.parse(result).episodes;
						$.each(episodes, function(key, item) {
							epTable.row.add(
								[
					              item.title,
					              item.published,
					              item.length,
					              buildPlayButton(item)
				                ]).draw(false);
						});
					})
					.error(function(err) {
						console.log(err.status + " " + err.statusText);
						var win = window.open("", "_self");
						win.document.write(err.responseText);
					});
				}
			});
			
		}).error(function(err) {
			console.log(err.status + " " + err.statusText);
			$("#show-content-wrap").empty();
			$("#show-content-wrap").append(err.responseText);
		});
	}, 500);
});