{{-- Load the vendor's scripts --}}
@mix('app.js')
@yield('javascript')
{{-- User javascript settings --}}
@yield('javascript-settings')
