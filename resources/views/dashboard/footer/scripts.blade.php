{{-- Load the vendor's scripts --}}
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@mix('app.js')

{{-- Javascript and libs --}}
<script>
    //Default javascript values
    window._path  = window.location.origin;
    var minSearch = {{ config('belich.minSearch') ?? 1 }};

    /**
     ****************************************
     * Default javascript methods
     ****************************************
     */
    // Loading button
    function submitForm(item) {
        loading(item);
        item.closest('form').submit();
    }

    // Loading button
    function loading(item, event) {
        item.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    }

    //Close alert with fadeOut
    function closeMenssage(container) {
        //Set container
        var container = document.getElementById('menssage-alert');
        //Set the opacity to 0
        container.style.opacity = '0';
        //Hide the div after 500ms
        setTimeout(function() {container.style.display = 'none';}, 500);
    }

    // Only on INDEX action
    @if(Belich::action() === 'index')
        // Live search
        function liveSearch(query = '')
        {
            //Min. search filter
            if(query.length < minSearch) {
                return;
            }

            $.ajax({
                url: "{{ route('dashboard.ajax.search') }}",
                method: 'GET',
                data: {
                    query: query,
                    resourceName: '{{ Belich::resourceName() }}',
                    type: 'search',
                    fields: '{{ Belich::searchFields() }}'
                },
                dataType: 'json',
                success: function(data) {
                    $('#tableContainer').html(data);
                }
            })
        }
    @endif

    /**
     ****************************************
     * Default jquery events
     ****************************************
     */
     jQuery(function() {
        /**
        * Configure the date
        */
        if ( $.jMaskGlobals ) {
            if ( $( '.mask-date') ) {
                $( '.mask-date' )
                    .mask( '00/00/0000', { placeholder: '__/__/____' } );
            }
        }

        // Only on INDEX action
        @if(Belich::action() === 'index')
            //Live search
            $(document).on('keyup', '#_search', function(event) {
                event.preventDefault();
                liveSearch($(this).val());
            });
        @endif
    });

</script>

{{-- Javascript metrics --}}
@hasMetrics($request ?? null)
    {{-- Load the javascript lib --}}
    {!! Chart::assets('js') !!}
    {{-- Create a container for each metric item --}}
    <script src="{!! asset('./vendor/belich/charts.min.js') !!}"></script>
    <script>
        {{-- Add the items --}}
        @stack('javascript-metrics')
    </script>
@endif

{{-- User custom javascript --}}
@stack('javascript')

{{-- Add custom jquery --}}
@stack('jquery')
