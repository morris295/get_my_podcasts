var Loader = function() {
	$(".cs-loader").hide();
	console.log("Loader initialized");
};

Loader.prototype.run = function() {
	$(".cs-loader").fadeIn("slow");
}

Loader.prototype.stop = function() {
	// Remove the loader from the display.
	$("body").removeClass("loader-body");
	$(".cs-loader").fadeOut("slow");
	
	// Fade in the page content.
	$("header").fadeIn("slow");
	$("section").fadeIn("slow");
	$("aside").fadeIn("slow");
	
	// Set the proper display properties for
	// these two elements.
	$("#content").css('display', 'table-cell');
	$("aside#nav").css('display', 'table-cell');
}