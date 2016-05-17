$(document).ready(function() {
	$("#subscribe").click(function() {
		console.log(window.location.host);
		
		var endpoint = "";
		
		if (window.location.host === 'localhost') {
			endpoint = "/get_my_podcasts/public/account/subscribe";
		} else {
			endpoint = "/account/subscribe";
		}
		
		var userId = $("#sub-user-id").val();
		var podcastId = $("#sub-show-id").val();
		var token = $('meta[name="csrf-token"]').attr("content");
		alertify.set({delay: 5000 });
		$.ajax({
			url: endpoint,
			headers: {
			  'X-CSRF-TOKEN': token
			},
			method: "POST",
			data: { "user_id": userId, "podcast_id": podcastId }
		}).success(function(response) {
			alertify.success("You've subscribed!");			
		}).fail(function(err) {
			console.log(err.responseText);
			alertify.error("An error occurred.");
			alertify.log(err);
		});
	});
});