(function ($) {
	"use strict";
  	
	uiLoad.load('/assets/admin/js/jquery/screenfull/dist/screenfull.min.js'); // for live server
//	uiLoad.load('/duroosapp/public/assets/admin/js/jquery/screenfull/dist/screenfull.min.js'); // for local server
	$(document).on('click', '[ui-fullscreen]', function (e) {
		e.preventDefault();
		if (screenfull.enabled) {
		  screenfull.toggle();
		}
	});
})(jQuery);
