{{-- Load the vendor's scripts --}}
@mix('app.js')

{{-- Javascript metrics --}}
@hasMetrics($request ?? null)
    {{-- Load the javascript lib --}}
    {!! Metric::assets('js') !!}
    {{-- Create a container for each metric item --}}
    <script src="{!! asset('./vendor/belich/charts.min.js') !!}"></script>
    <script>
        {{-- Add the items --}}
        @stack('javascript-metrics')
    </script>
@endif

{{-- User custom javascript --}}
@yield('javascript')
