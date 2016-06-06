var setSubscribed = function(element) {
	element.attr('disabled', true);
	element.html("Subscribed");
	element.attr('style', 'background-color: green !important');
};

$(document).ready(function() {
	
	$(document).on('click', "#subscribe", function() {
		console.log(window.location.host);
		
		var endpoint = "";
		
		if (window.location.host.indexOf('localhost') !== -1) {
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
			setSubscribed($("#subscribe"));
		}).fail(function(err) {
			alertify.error("An error occurred.");
			alertify.log(err.message);
		});
	});
	
	$('[id^=unsub-show-]').click(function(e) {
		
		var endpoint = "";
		
		if (window.location.host === 'localhost') {
			endpoint = "/get_my_podcasts/public/account/unsubscribe";
		} else {
			endpoint = "/account/unsubscribe";
		}
		
		var buttonClicked = $(this);
		
		alertify.confirm("Are you sure you want to unsubscribe?", function(e) {
			if (e) {
				var value = buttonClicked.attr('data-value');
				
				var podcastId = $("#unsub-"+value+"-podcast-id").val();
				var userId = $("#unsub-"+value+"-user-id").val();
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
					alertify.success("Unsubscribed");		
				}).fail(function(err) {
					console.log(err.responseText);
					alertify.error("An error occurred.");
					alertify.log(err);
				});
			}
		});
	});
});