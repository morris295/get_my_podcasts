$(document).ready(function() {
//	$('[id^=episodes-]').hide();
	$('[id^=show-]').click(function(e) {
		var value = $(this).attr('data-value');
		$("#episodes-"+value).toggle();
	});
});