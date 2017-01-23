$(document).ready(function() {
	//var audio = $("#player");
	
	var previousPageTitle = $(document).prop('title');
	
	$(document).on("click", "#savePlaylist", function(e) {
		endpoint = '/playlists/create',
		token = $('meta[name="csrf-token"]').attr("content"),
		uid = parseInt($(e.target).closest("a").attr("data-value"));
		
		alertify.prompt("Please name this playlist:", function(e, val) {
			if (e) {
				
				var data = {
					user_id: uid,
					contents: myPlaylist.playlist,
					playlist_name: val
				};
				
				alertify.set({
					labels: {
						ok: "Yes",
						cancel: "No"
					}
				});
				
				alertify.confirm("Mark as the default playlist?", function(e) {
					if (e) {
						data.keep_current = 1;
					} else {
						data.keep_current = 0;
					}
					
					asynch.sendRequest(endpoint, "POST", token, data)
					.then(function(result) {
						console.log("Success!");
						toastr.success("Success", "Playlist saved.");
					},
					function(result) {
						console.log("Failure! Boo!");
						toastr.error("Failed", "Playlist not saved.");
					});
				});
			}
		});
	});
	
	$(document).on("click", "#clearPlaylist", function(e) {
		myPlaylist.playlist.length = 0;
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
