/*
 * Bones Scripts File
 * Author: Eddie Machado
 *
 * This file should contain any js scripts you want to add to the site.
 * Instead of calling it in the header or throwing it inside wp_head()
 * this file will be called automatically in the footer so as not to
 * slow the page load.
 *
 * There are a lot of example functions and tools in here. If you don't
 * need any of it, just remove it. They are meant to be helpers and are
 * not required. It's your world baby, you can do whatever you want.
*//*
 * Get Viewport Dimensions
 * returns object with viewport dimensions to match css in width and height properties
 * ( source: http://andylangton.co.uk/blog/development/get-viewport-size-width-and-height-javascript )
*/function updateViewportDimensions(){var e=window,t=document,n=t.documentElement,r=t.getElementsByTagName("body")[0],i=e.innerWidth||n.clientWidth||r.clientWidth,s=e.innerHeight||n.clientHeight||r.clientHeight;return{width:i,height:s}}function loadGravatars(){viewport=updateViewportDimensions();viewport.width>=768&&jQuery(".comment img[data-gravatar]").each(function(){jQuery(this).attr("src",jQuery(this).attr("data-gravatar"))})}var viewport=updateViewportDimensions(),waitForFinalEvent=function(){var e={};return function(t,n,r){r||(r="Don't call this twice without a uniqueId");e[r]&&clearTimeout(e[r]);e[r]=setTimeout(t,n)}}(),timeToWaitForLast=100;jQuery(document).ready(function(e){function t(){e(".menu-toggle").click(function(t){if(e(".primary-navigation").hasClass("open")){e(".site-header").removeClass("open");e(".primary-navigation").removeClass("open");e(".eo-navigation").removeClass("open");e(".menu-toggle").removeClass("up")}else{e(".site-header").removeClass("smaller");e(".site-header").addClass("open");e(".primary-navigation").addClass("open");e(".eo-navigation").addClass("open");e(".menu-toggle").addClass("up")}})}function n(){e(".search-toggle").click(function(t){if(e(".primary-navigation").hasClass("search")){e(".site-header").removeClass("search");e(".primary-navigation").removeClass("search")}else{e(".site-header").addClass("search");e(".primary-navigation").addClass("search")}})}function r(){}function i(){viewport.width>=768?e(".expand").click(function(){e(this).parent("li").children(".sub-menu").hasClass("open")?e(this).parent("li").children(".sub-menu").removeClass("open"):e(this).parent("li").children(".sub-menu").addClass("open")}):e(".expand-mobile").click(function(){e(this).parent("li").children(".sub-menu").hasClass("open")?e(this).parent("li").children(".sub-menu").removeClass("open"):e(this).parent("li").children(".sub-menu").addClass("open")})}function s(t){e(".popup").slideFadeToggle(function(){t.removeClass("selected")})}window.onload=t();window.onload=n();window.onload=i();loadGravatars();e(function(){e(".poptrigger").on("click",function(){if(e(this).hasClass("selected"))s(e(this));else{e(this).addClass("selected");e(".popup").slideFadeToggle()}return!1});e(".close").on("click",function(){s(e(".poptrigger"));return!1})});e.fn.slideFadeToggle=function(e,t){return this.animate({opacity:"toggle",height:"toggle"},"fast",e,t)}});