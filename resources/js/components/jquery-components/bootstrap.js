// //flatpickr
// import flatpickr from "flatpickr"

(function () {
	"use strict";

	//Scroll to top
	var viewPortWidth = $( window ).width();

	$( window ).scroll(function(event) {
		event.preventDefault();
		if ( viewPortWidth > 480 ) {
			if ( $( this ).scrollTop() > 180 ) {
				$( '.scrollTop' ).fadeIn();
			} else {
				$( '.scrollTop' ).fadeOut();
			}
		}
	});

	$( '.scrollTop' ).click( function( event ) {
		$( 'html, body' ).animate( {scrollTop : 0 }, 600 );
		event.preventDefault();
	});

	/**
	* Configure the maska: date,...
	*/
	if ( $.jMaskGlobals ) {
		if(dateFormat == null) {
			var dateFormat = ['00/00/0000', '__/__/___'];
		}

		if ( $( '.mask-date') ) {
			$( '.mask-date' ).mask( dateFormat[0], { placeholder: dateFormat[1] } );
		}
	}

	/**
	* Responsive navbar collapse
	*/
	$( '.collapse-button' ).click( function( event ) {
		$('#navbar-collapse-button-open,#navbar-collapse-button-close').toggle();
		$('.navbar-items').toggle();
	});
})();
