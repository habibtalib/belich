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
            //Make a live search
            function liveSearch(query = '') {
                //Hide icon
                if(query.length === 0) {
                    window.onSelection('#icon-search-reset', 'hide');
                }
                //Min. search filter
                if(query.length < minSearch) {
                    return;
                }
                //Ajax request
                var request = new XMLHttpRequest();
                request.open('GET', '{{ route('dashboard.ajax.search') }}?type=search&query=' + query + '&resourceName={{ Belich::resourceName() }}&fields={{ Helper::searchFields() }}', true);
                request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                request.onload = function() {
                    if (this.status == 200 && this.readyState == 4) {
                        document.getElementById('table-container').innerHTML = JSON.parse(this.response);
                    }
                };
                request.send();
            }

            {{-- Custom jquery --}}
            document.addEventListener('DOMContentLoaded', function(event) {
                //live search
                if(document.getElementById('_search')) {
                    document.getElementById('_search')
                        .addEventListener('keyup', function(event) {
                            window.liveSearch(this.value);
                        });
                }
            });
        </script>
    @endif
@endpush
