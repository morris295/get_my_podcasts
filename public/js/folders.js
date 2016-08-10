$(document).ready(function() {
	var settings = $.extend({
		opacity: 0.2,							// Opacity of non-selected items
		marginTopAdjust: false,					// Adjust the margin-top for the folder area based on row selected?
		marginTopBase: '0px',					// If margin-top-adjust is "true", the natural margin-top for the area
		marginTopFirst: '0px',					// If margin-top-adjust is "true", the natural margin-top for the area
		marginTopIncrement: '-100px',			// If margin-top-adjust is "true", the increment of margin-top per row
		animationSpeed: 350,					// Time (in ms) for transition
		URLrewrite: false,						// Use URL rewriting?
		URLbase: "",							// If URL rewrite is enabled, the URL base of the page where used
		internalLinkSelector: '.jaf-internal a'	// a jQuery selector containing links to content within a jQuery App Folder
	});
	
	$(".folderContent").hide();
	
	$(".folder").click(function(e) {
		e.preventDefault();
		var openFolder = $(this).attr('id');
		var folderContent = $('.folderContent.' + openFolder);
		var folderContentShown = $(folderContent).css("display") != "none";
		var clickedFolder = $(this);

		if ($(" .jaf-container .active-tool").length === 0) {
			var row = clickedFolder.parent(".jaf-row");
			$(row).after(folderContent);
						
			$(this).addClass('active-tool', settings.animationSpeed);
			$(folderContent).slideToggle(settings.animationSpeed);
					
			$(" .jaf-container").find(".folder").not(clickedFolder).each(function() {
				if (!folderContentShown) {
					$(this).animate({ opacity: settings.opacity }, settings.animationSpeed);
				}
				else {
					$(this).animate({ opacity: 1.00 }, settings.animationSpeed);
				}
			});
			
			if( settings.marginTopAdjust === false) {
				return false;
			//if no margin-top adjustment, leave it alone
			} else {
			// To enable shifting of the rows' top margin on click (works best with overflow: hidden):
				// For Row 2, default -50px top-margin (change below and line 133)
				var $i = $(this).parent().index('.jaf-row');
				var marTop = settings.marginTopBase - (settings.marginTopIncrement * ($i));
				$(this).parent().parent().animate({ marginTop: marTop }, settings.animationSpeed );
			}
			
			if( settings.marginTopAdjust === false) {
				return false;
			//if no margin-top adjustment, leave it alone
			} else {
			// To enable shifting of the rows' top margin on click (works best with overflow: hidden):
				// For Row 2, default -50px top-margin (change below and line 133)
				var $i = $(this).parent().index('.jaf-row');
				var marTop = settings.marginTopBase - (settings.marginTopIncrement * ($i));
				$(this).parent().parent().animate({ marginTop: marTop }, settings.animationSpeed );
			}
			
			var hash = $(clickedFolder).attr('id');
			var node = $( '#' + hash );
			// if ( node.length ) {
			// 	node.attr( 'id', '' );
			// }
			document.location.hash = hash;
			if ( node.length ) {
				node.attr( 'id', hash );
			}
		} else {
			
			if (folderContentShown) {
				//Active icon was clicked
				$(this).toggleClass("active-tool");
				$(folderContent).slideToggle(settings.animationSpeed);
				$(" .jaf-container").find(".folder").not(clickedFolder).each(function() {
					if (!folderContentShown) {
						$(this).animate({ opacity: 0.20 }, settings.animationSpeed);
					}
					else {
						$(this).animate({ opacity: 1.00 }, settings.animationSpeed);
					}
				});

				document.location.hash = '';
				
				
				//Reset the margin-top for the container
				$(this).parent().parent().animate({ marginTop: settings.marginTopBase }, settings.animationSpeed );

			} else {

				var speed = settings.animationSpeed;

				if ($(this).parent().find('.active-tool').length !== 0){
					speed = 0;
				}

				//Inactive icon was clicked
				$('.folderContent').slideUp(speed);
				$('.active-tool').removeClass('active-tool');
				$(' .jaf-container .folder').animate({ opacity: 1.00 }, speed);

				//Open clicked icon
				var row = clickedFolder.parent(".jaf-row");
				$(row).after(folderContent);
							
				$(this).addClass('active-tool', speed);
				$(folderContent).slideToggle(speed);
						
				$(" .jaf-container").find(".folder").not(clickedFolder).each(function() {
					if (!folderContentShown) {
						$(this).animate({ opacity: settings.opacity }, speed);
					}
					else {
						$(this).animate({ opacity: 1.00 }, speed);
					}
				});

				var hash = $(clickedFolder).attr('id');
				var node = $( '#' + hash );
				// if ( node.length ) {
				// 	node.attr( 'id', '' );
				// }
				document.location.hash = hash;
				if ( node.length ) {
					node.attr( 'id', hash );
				}
								
				//Reset the margin-top for the container
				$(this).parent().parent().animate({ marginTop: settings.marginTopBase }, settings.animationSpeed );
			}
			
			event.preventDefault();
		}
	});
	
	$('.close').click(function(e){

		var openFolder = $(e.target).attr("data-value");
		var folderContent = $('.folderContent.' + openFolder);
		var folderContentShown = $(folderContent).css("display") != "none";
		$(this).parent().removeClass("active-tool");
		$(this).parent().slideToggle(settings.animationSpeed);
		
		$(" .jaf-container").find(".folder").not(openFolder).each(function() {
			if (!folderContentShown) {
				$(this).animate({ opacity: 0.20 }, settings.animationSpeed);
			}
			else {
				$(this).animate({ opacity: 1.00 }, settings.animationSpeed);
			}
		});
		
		//Reset the margin-top for the container
		$(this).parent().parent().animate({ marginTop: settings.marginTopBase }, settings.animationSpeed );
	});
	
});