// import flatpickr from "flatpickr"
// import Spanish from "flatpickr/dist/l10n/es.js";

/**
 * Default values
 */
window._path = window.location.origin;

$(function() {
    "use strict";

    /**
    * Configure the date
    */
    if ( $.jMaskGlobals ) {
        if ( $( '.mask-date') ) {
            $( '.mask-date' )
                .mask( '00/00/0000', { placeholder: '__/__/____' } );
        }
    }
});
