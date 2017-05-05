var Playlist = function() { };

var _myPlaylist = null;

Playlist.prototype.init = function() {
	_myPlaylist = new jPlayerPlaylist({
	    jPlayer: "#jplayer_N",
	    cssSelectorAncestor: "#jp_container_N"
	  }, [], {
	    playlistOptions: {
	      enableRemoveControls: true,
	      autoPlay: false
	    },
	    swfPath: "js/jPlayer",
	    supplied: "webmv, ogv, m4v, oga, mp3",
	    smoothPlayBar: true,
	    keyEnabled: true,
	    audioFullScreen: false,
	    play: function(e) {
	      $(document).prop('title', e.jPlayer.status.media.title);
	    },
	    paused: function(e) {
	    	$(document).prop('title', 'CastNinja');
	    },
	    ended: function(e) {
	      $(document).prop('title', 'CastNinja');
	    }
	})
	
	return _myPlaylist;
};

Playlist.prototype.clearPlaylist = function(softDelete) {
	// Empty playlist.
	_myPlaylist.playlist.length = 0;
	
	// Clear the UI elements containing now removed playlist items.
	$("#playlist").find("ul.dropdown-menu").empty();
	$(".jp-seek-bar").find(".jp-title").empty();
	
	
	// Get values to remove playlist from DB.
	var id = sessionStorage.playlist_id;
	var token = $('meta[name="csrf-token"]').attr("content");
	var endpoint = config.getBaseUrl() + "playlists/delete/" + id;
	
	// Empty the session storage playlist object.
	sessionStorage.playlist = {};
	sessionStorage.playlist_id = null;
	
	if (!softDelete) {
		// Clear the playlist in the DB.
		asynch.sendRequest(endpoint, "DELETE", token)
			.success(function(result) {
				//var dat = JSON.parse(result);
				if (result.code === 200) {
					toastr.success("Playlist deleted.");
				}
			}
		);	
	}
	
	return this;
};

Playlist.prototype.savePlaylist = function(playlistObj) {
	return asynch.sendRequest(endpoint, "POST", token, playlistObj);
};

Playlist.prototype.addToPlaylist = function(item) {
	_myPlaylist.playlist.push(item);
	return this;
};

Playlist.prototype.addToTopOfPlaylist = function(item) {
	_myPlaylist.playlist.unshift(item);
}

Playlist.prototype.setPlaylist = function(obj) {
	_myPlaylist.playlist = obj;
	return this;
};

Playlist.prototype.getPlaylist = function() {
	return _myPlaylist.playlist;
};