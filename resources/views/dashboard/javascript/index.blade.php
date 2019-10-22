@push('javascript')
    {{-- Javascript metrics --}}
    @hasMetrics($request ?? null)

        {{-- Load the javascript lib --}}
        {!! Chart::assets('js') !!}

        {{-- Custom charts --}}
        @mix('charts.legends.min.js')

        <script>
            {{-- Create a container for each metric item --}}
            @stack('javascript-metrics')

            {{-- Custom jquery --}}
            $(function() {
                /*
                Section: Search
                Description: Live search
                */
                if($('#_search')) {
                    $('#_search').on('keyup', function(event) {
                        event.preventDefault();
                        liveSearch($(this).val());
                    });
                }
            });
        </script>
    @endif
@endpush
