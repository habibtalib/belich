{{-- Load the vendor's scripts --}}
@mix('app.js')

{{-- Default functions --}}
<script>
    {{-- Loading button --}}
    function submitForm(item) {
        loading(item);
        item.closest('form').submit();
    }

    {{-- Loading button --}}
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
