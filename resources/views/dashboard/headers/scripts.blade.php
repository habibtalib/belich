{{-- Load the vendor's scripts --}}
@mix('app.js')

{{-- Global Javascript --}}
<script>
    function loading(item, event) {
        item.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        event.stopPropagation();
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
