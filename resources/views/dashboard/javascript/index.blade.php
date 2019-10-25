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

            @if(config('belich.liveSearch.enable') === true)
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
            @endif
        </script>
    @endif
@endpush
