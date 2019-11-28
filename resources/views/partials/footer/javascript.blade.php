{{-- Load the vendor's scripts from webpack: you can load all the dependecies you need --}}
{{-- @mix('app.js') --}}

{{-- Load all the default js --}}
@include('belich::dashboard.javascript.default')

{{-- Stacks of scripts --}}
@stack('javascript')

{{-- Not repeat scripts (only one) --}}
@yield('javascript-no-repeat')

{{-- Conditional fields --}}
@yield('javascript-conditional')

{{-- Javascript metrics --}}
@hasMetrics($request ?? null)
    {{-- Load the javascript lib --}}
    {!! Chart::assets('js') !!}
    {{-- Custom charts --}}
    @mix('charts.legends.min.js')
    <script>
        {{-- Create a container for each metric item --}}
        @stack('javascript-metrics')
    </script>
@endif

