/**
 * Jquery automatically handles sending the CSRF token as a header based on
 * the value of the "XSRF" token cookie.
 */
 $.ajaxSetup({
     headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
 });
