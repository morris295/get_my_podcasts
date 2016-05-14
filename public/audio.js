$(document).ready(function() {

	var audio = $("#player");
	$("[id^=play-episode]").click(function(e) {
		e.preventDefault();
		$("#mpeg-source").attr("src", $(this).attr("data-value"));
		var title = $(this).attr("data-episodeTitle");
		$(this).attr("class", "glyphicon glyphicon-volume-up");
		
		audio[0].pause();
		audio[0].load();
		
		audio[0].oncanplaythrough = function() {
			audio[0].play();
			$("#episode-playing-title").text("");
			$("#episode-playing-title").text(title);
		};
	});
});