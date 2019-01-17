// import flatpickr from "flatpickr"
// import Spanish from "flatpickr/dist/l10n/es.js";

/**
 * Default values
 */
window._path = window.location.origin;

$(function() {
    "use strict";

    /**
    * Scroll to top
    */
    $( window ).scroll(function(event) {
        event.preventDefault();
        if ( viewPortWidth > 480 ) {
            if ( $( this ).scrollTop() > 180 ) {
                $( '.scroll-to-top' )
                    .fadeIn();
            } else {
                $( '.scroll-to-top' )
                    .fadeOut();
            }
        }
    });

    $( '.scroll-to-top' ).click( function( event ) {
        event.preventDefault();
        $( 'html, body' )
            .animate( {scrollTop : 0 }, 600 );
    });

    /**
    * Configure the date
    */
    if ( $.jMaskGlobals ) {
        if ( $( '.mask-date') ) {
            $( '.mask-date' )
                .mask( '00/00/0000', { placeholder: '__/__/____' } );
        }
    }

    /**
    * Navbar collapse
    */
    $( '#nav-navbar-button-collapse' ).on( 'click', function() {
        $( '#nav-navbar-content' )
            .toggle();
    });
});
