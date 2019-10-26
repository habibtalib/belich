@push('javascript')
    {{-- Include metrics --}}
    @hasMetrics($request ?? null)

        {{-- Load the javascript lib --}}
        {!! Chart::assets('js') !!}

        {{-- Custom charts --}}
        @mix('charts.legends.min.js')

        {{-- Default scripts --}}
        <script>
            {{-- Create a container for each metric item --}}
            @stack('javascript-metrics')
        </script>
    @endif

    {{-- Include life search --}}
    @if(config('belich.liveSearch.enable'))
        <script>
            {{-- Custom jquery --}}
            document.addEventListener('DOMContentLoaded', function(event) {
                /*
                Section: Search
                Description: Live search
                */
                if(document.getElementById('_search')) {
                    document.getElementById('_search')
                        .addEventListener('keyup', function(event) {
                            liveSearch(this.value);
                        });
                }
            });
        </script>
    @endif
@endpush
