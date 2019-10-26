<footer>
    {{-- Load the vendor's scripts from webpack: you can load all the dependecies you need --}}
    {{-- @mix('app.js') --}}

    {{-- Load all the default js --}}
    @include('belich::dashboard.javascript.default')

    {{-- Belich custom page javascript --}}
    @stack('javascript')

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
</footer>
