<footer>
    @if(config('belich.turbolinks') === false)
        {{-- Load the vendor's scripts from webpack --}}
        @mix('app.js')

        {{-- Load all the custom js --}}
        @include('belich::dashboard.javascript.default')
    @endif

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
