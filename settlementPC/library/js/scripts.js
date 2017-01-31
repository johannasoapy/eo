/*
 * Bones Scripts File
 * Author: Eddie Machado
 *
*/


/*
 * Get Viewport Dimensions
 * returns object with viewport dimensions to match css in width and height properties
 * ( source: http://andylangton.co.uk/blog/development/get-viewport-size-width-and-height-javascript )
*/
function updateViewportDimensions() {
	var w=window,d=document,e=d.documentElement,g=d.getElementsByTagName('body')[0],x=w.innerWidth||e.clientWidth||g.clientWidth,y=w.innerHeight||e.clientHeight||g.clientHeight;
	return { width:x,height:y };
}
// setting the viewport width
var viewport = updateViewportDimensions();

/*
 * Throttle Resize-triggered Events
 * Wrap your actions in this function to throttle the frequency of firing them off, for better performance, esp. on mobile.
 * ( source: http://stackoverflow.com/questions/2854407/javascript-jquery-window-resize-how-to-fire-after-the-resize-is-completed )
*/
var waitForFinalEvent = (function () {
	var timers = {};
	return function (callback, ms, uniqueId) {
		if (!uniqueId) { uniqueId = "Don't call this twice without a uniqueId"; }
		if (timers[uniqueId]) { clearTimeout (timers[uniqueId]); }
		timers[uniqueId] = setTimeout(callback, ms);
	};
})();

// how long to wait before deciding the resize has stopped, in ms. Around 50-100 should work ok.
var timeToWaitForLast = 100;


/*
 * Here's an example so you can see how we're using the above function
 *
 * This is commented out so it won't work, but you can copy it and
 * remove the comments.
 *
 *
 *
 * If we want to only do it on a certain page, we can setup checks so we do it
 * as efficient as possible.
 *
 * if( typeof is_home === "undefined" ) var is_home = $('body').hasClass('home');
 *
 * This once checks to see if you're on the home page based on the body class
 * We can then use that check to perform actions on the home page only
 *
 * When the window is resized, we perform this function
 * $(window).resize(function () {
 *
 *    // if we're on the home page, we wait the set amount (in function above) then fire the function
 *    if( is_home ) { waitForFinalEvent( function() {
 *
 *	// update the viewport, in case the window size has changed
 *	viewport = updateViewportDimensions();
 *
 *      // if we're above or equal to 768 fire this off
 *      if( viewport.width >= 768 ) {
 *        console.log('On home page and window sized to 768 width or more.');
 *      } else {
 *        // otherwise, let's do this instead
 *        console.log('Not on home page, or window sized to less than 768.');
 *      }
 *
 *    }, timeToWaitForLast, "your-function-identifier-string"); }
 * });
 *
 * Pretty cool huh? You can create functions like this to conditionally load
 * content and other stuff dependent on the viewport.
 * Remember that mobile devices and javascript aren't the best of friends.
 * Keep it light and always make sure the larger viewports are doing the heavy lifting.
 *
*/

/*
 * We're going to swap out the gravatars.
 * In the functions.php file, you can see we're not loading the gravatar
 * images on mobile to save bandwidth. Once we hit an acceptable viewport
 * then we can swap out those images since they are located in a data attribute.
*/
function loadGravatars() {
  // set the viewport using the function above
  viewport = updateViewportDimensions();
  // if the viewport is tablet or larger, we load in the gravatars
  if (viewport.width >= 768) {
  jQuery('.comment img[data-gravatar]').each(function(){
    jQuery(this).attr('src',jQuery(this).attr('data-gravatar'));
  });
	}
} // end function


/*
 * Put all your regular jQuery in here.
*/
jQuery(document).ready(function($) {
	
	//open and close header nav
	function toggleNav() {
        $("#closemenu").click(function() {
                    $('.menu-toggle').removeClass('open').blur();
                    $('.primary-navigation').css('display','none');
                    $(".site-header").removeClass("open");
                    $(".site-header").removeClass("search");
                });
		$(".menu-toggle").click(function(){
            var trigger = this;
            var i = 'none';
            if ($(this).hasClass("live")){
                i = '#settlement-menu';
            }
            else if ($(this).hasClass("learn")){
                i = '#learner-menu';
            }
            else if ($(this).hasClass("calendar")){
                i = '#events-menu';
            }
            else if ($(this).hasClass("more")){
                i = '#supporting-menu';
            }
            function thisOpen(){
                $(trigger).addClass("open");
            }
			if ($(".site-header").hasClass("open")){
                if ($(this).hasClass("open")){
                    $(this).removeClass("open").blur();
                    $('.menu-toggle').removeClass('open');
                    //$(i).removeClass('open');
                    $(".site-header").removeClass("open");
                    $(".site-header").removeClass("search");
                } else {
                    $(".primary-navigation").css('display','none');
                    $('.menu-toggle').removeClass('open');
                    $(i).fadeIn(800);
                    //$(i).addClass("open");
                    setTimeout(thisOpen,800);
                }
            } else {
                $(".primary-navigation").css('display','none');
                $(".site-header").addClass("open");
                $('.menu-toggle').removeClass('open');
                $(i).fadeIn(400);
                setTimeout(thisOpen,400);
            }
			
		});
	}

	$(".site-header").load = toggleNav();
    
    
	function toggleSearch() {
        function focuss(){
            $("#s").focus();
        }
		$(".search-toggle").click(function(e){
            if ($(".site-header").hasClass("open")){
				$(".site-header").addClass("search");
                setTimeout(focuss,800);
                if ($(".site-header").hasClass("search")){
                    focuss();
                }
            } 
			else if ($(".site-header").hasClass("search")){
				$(".site-header").removeClass("search");
            } else {
				$(".site-header").addClass("search");
                setTimeout(focuss,800);
            }
			
		});
	}
	$(".site-header").load = toggleSearch();



  /*
   * Let's fire off the gravatar function
   * You can remove this if you don't need it
  */
	loadGravatars();
	
	// popup windows (add class .popup to html container ) from http://stackoverflow.com/questions/1328723/how-to-generate-a-simple-popup-using-jquery
	function deselect(e) {
			$('.popup').slideFadeToggle(function() {
			  e.removeClass('selected');
			});    
		}
	      
		$(function() {
			$('.poptrigger').on('click', function() {
			  if($(this).hasClass('selected')) {
				deselect($(this));
                  $('#profile-toggle').removeClass('open');
			  } else {
                $('#profile-toggle').addClass('open');
				$(this).addClass('selected');
				$('.popup').slideFadeToggle();
			  }
			  return false;
			});
			  
			$('.close').on('click', function() {
			  deselect($('.poptrigger'));
			  return false;
			});
		});
	      
	    $.fn.slideFadeToggle = function(easing, callback) {
			return this.animate({ opacity: 'toggle', height: 'toggle' }, 'fast', easing, callback);
	    };
    
    // smooth scroll
    $(function() {
          $('a[href*="#"]:not([href="#content"])').click(function() {
            if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
              var target = $(this.hash);
              target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
              if (target.length) {
                $('html,body').animate({
                  scrollTop: target.offset().top
                }, 1000);
                return false;
              }
            }
          });
        });
    
    
    $(function() {
        var labelID;

        $('.simple-label').click(function() {
               labelID = $(this).attr('for');
               $('#'+labelID).trigger('click');
        });
    });
    
    // fix background jumping in IE 11 (supposed to work for 8 but doesn't), from https://coderwall.com/p/hlqqia/ie-fix-for-jumpy-fixed-bacground
    if(navigator.userAgent.match(/Trident\/7\./)) { // if IE
        $('body').on("mousewheel", function () {
            // remove default behavior
            event.preventDefault(); 

            //scroll without smoothing
            var wheelDelta = event.wheelDelta;
            var currentScrollPosition = window.pageYOffset;
            window.scrollTo(0, currentScrollPosition - wheelDelta);
        });
    }
    
    //https://www.webfactory.de/blog/embedding-accessible-and-crossbrowser-compatible-svgs-into-your-website
    
    $('.fx-svg').each(function(){ var fxSvg = $(this); var attr = {}; $.each(this.attributes, function(){ attr[this.nodeName] = this.nodeValue; }); attr.alt = fxSvg.text(); attr.src = fxSvg.attr('data-' + (Modernizr.svg ? 'svg' : 'bitmap')); $('<img>') .attr(attr) .show() .replaceAll(this); });

}); /* end of as page load scripts */
