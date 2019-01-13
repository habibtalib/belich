{{-- Load the vendor's scripts --}}
@mix('bootstrap.js')
@mix('custom.js')
@yield('javascript')
{{-- User javascript settings --}}
@yield('javascript-settings')
