var setSubscribed = function(element) {
//	element.attr('disabled', true);
//	element.html("Following");
//	element.attr('style', 'background-color: green !important');
	element.attr('style', 'background-color: red !important');
};

$(document).ready(function() {

	$(document).on('click', "[id^=follow-]", function(event) {
		console.log(window.location.host);

		endpoint = config.getBaseUrl() + "account/subscribe";

		var followIcon = event.target;
		console.log(followIcon);
		var followBtn = $($(event.target)[0].closest('a'));
		var userId = followBtn.attr("data-sub-user-id");
		var podcastId = followBtn.attr("data-sub-show-id");
		var token = $('meta[name="csrf-token"]').attr("content");
		data = { "user_id": userId, "podcast_id": podcastId };

		asynch.sendRequest(endpoint, "POST", token, data).success(function(result) {
			//alertify.success("You're following this podcast!");
			//setSubscribed($("#follow"));
			toastr.success("Success", "You're following this podcast!");
			$(followIcon).removeClass("fa fa-heart-o");
			$(followIcon).addClass("fa fa-heart text-danger");
		}).error(function(err) {
			console.error(err.status + " " + err.statusText);
		});
	});

	$(document).on('click', '[id^=unsub-show-]', function(e) {

		var endpoint = "";

		endpoint = config.getBaseUrl() + "account/unsubscribe";

		var buttonClicked = $(this);

		alertify.confirm("Are you sure you want to stop following?", function(e) {
			if (e) {
				var value = buttonClicked.attr('data-value');

				var podcastId = $("#unsub-" + value + "-podcast-id").val();
				var userId = $("#unsub-" + value + "-user-id").val();
				var token = $('meta[name="csrf-token"]').attr("content");
				data = { "user_id": userId, "podcast_id": podcastId };

				asynch.sendRequest(endpoint, "POST", token, data).success(function(result) {
					toastr.success("Success", "You are no longer following this podcast.");
				}).error(function(err) {
					console.log(err.status + " " + err.statusText);
					$("#show-content-wrap").empty();
					$("#show-content-wrap").append(err.responseText);
				});
			}
		});
	});
});