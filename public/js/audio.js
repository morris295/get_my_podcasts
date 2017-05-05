$(document).ready(function() {
	//var audio = $("#player");
	
	var previousPageTitle = $(document).prop('title');
	
	$(document).on("click", "#savePlaylist", function(e) {
		endpoint = '/playlists/create',
		token = $('meta[name="csrf-token"]').attr("content"),
		uid = parseInt($(e.target).closest("a").attr("data-value"));
		
		dialog.dialog("open");
		
		var data = {
			user_id: uid,
			contents: myPlaylist.playlist,
			playlist_name: val
		};
		
		playlist.savePlaylist(data)
			.then(function(result) {
				toastr.success("Playlist saved.");
			},
			function(err) {
				console.log(err);
				toastr.error("Failed to save playlist.");
			})
	});
	
	$(document).on("click", "#clearPlaylist", function(e) {
		playlist.clearPlaylist();
	});
	
	$(document).on("click", "[id^=play-episode]", function(e) {
		e.preventDefault();
		var source = $(this).attr("data-value");
		var title = $(this).attr("data-episodeTitle");
		//$("#play-icon").attr("class", "glyphicon glyphicon-volume-up");
		
		myPlaylist.add({
			title: title,
			artist: "",
			mp3: source,
			poster: ""
		});
		
		console.log(myPlaylist);
		
		$(document).prop('title', title + " - Get My Podcasts");
		setTimeout(function() {
			myPlaylist.play();
		}, 500);
	});
	
	$(document).on("click", "[id^=add-to-pl]", function(e) {
		e.preventDefault();
		var source = $(this).attr("data-value");
		var title = $(this).attr("data-episodeTitle");
		
		myPlaylist.add({
			title: title,
			artist: "",
			mp3: source,
			poster: ""
		});
		$(document).prop('title', title + " - Get My Podcasts");
		
		setTimeout(function() {
			myPlaylist.play();
		}, 3500);
	});
	
	$(document).on("click", "#popout", function(e) {
		e.preventDefault();
		
		var episodeSource = encodeURIComponent($("#mpeg-source").attr("src"));
		var location = config.getBaseUrl() + "player/open/" + episodeSource;
		
		if (episodeSource === null || episodeSource === undefined) {
			alertify.alert("No episode playing.");
		} else {
			var win = window.open();
			win.location = location;
		}
		
	});
});
