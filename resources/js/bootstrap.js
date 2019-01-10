/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */
try {
    window.$ = window.jQuery = require('jquery');
} catch (e) {}

/**
 * Jquery automatically handles sending the CSRF token as a header based on
 * the value of the "XSRF" token cookie.
 */
 $.ajaxSetup({
     headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
 });

/**
 * Dashboard libraries
 */
window.jMaskGlobals = require( 'jquery-mask-plugin' );
window.autoComplete = require( 'easy-autocomplete' );
