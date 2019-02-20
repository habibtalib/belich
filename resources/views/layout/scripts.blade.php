{{-- Load the vendor's scripts --}}
@mix('app.js')
@yield('javascript')
{{-- User javascript settings --}}
@yield('javascript-settings')
{{-- User javascript metrics --}}
@yield('javascript-metrics')
@stack('javascript-metrics-items')
