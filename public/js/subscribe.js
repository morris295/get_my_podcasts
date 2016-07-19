var config = new Configuration();
var async = new Async();

var setSubscribed = function(element) {
	element.attr('disabled', true);
	element.html("Subscribed");
	element.attr('style', 'background-color: green !important');
};

$(document).ready(function() {
	
	$(document).on('click', "#subscribe", function() {
		console.log(window.location.host);
		
		
		endpoint = config.getBaseUrl() + "account/subscribe";
		
		var userId = $("#sub-user-id").val();
		var podcastId = $("#sub-show-id").val();
		var token = $('meta[name="csrf-token"]').attr("content");
		alertify.set({delay: 5000 });
		
		async.sendRequest(endpoint, "POST", function(result) {
			alertify.success("You've subscribed!");
			setSubscribed($("#subscribe"));
		});
	});
	
	$(document).on('click', '[id^=unsub-show-]', function(e) {
		
		var endpoint = "";
		
		endpoint = config.getBaseUrl() + "account/unsubscribe";
		
		var buttonClicked = $(this);
		
		alertify.confirm("Are you sure you want to unsubscribe?", function(e) {
			if (e) {
				var value = buttonClicked.attr('data-value');
				
				var podcastId = $("#unsub-"+value+"-podcast-id").val();
				var userId = $("#unsub-"+value+"-user-id").val();
				var token = $('meta[name="csrf-token"]').attr("content");
				alertify.set({delay: 5000 });
				
				async.sendRequest(endpoint, "POST", function(result) {
					alertify.success("Unsubscribed");
				});
			}
		});
	});
});