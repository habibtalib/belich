@push('javascript')
    @if(config('belich.liveSearch.enable'))
        <script>
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
