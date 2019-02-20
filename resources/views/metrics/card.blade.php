@component('belich::components.card')
    @slot('header', $metric->name)
    @slot('width', $metric->width ?? 'w-1/3')
    @slot('content')
        <div class="ct-chart {{ $metric->uriKey }} ct-perfect-fourth max-h-full"></div>
    @endslot
@endcomponent

@section('css-metrics')
    <link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
    <style>
        .ct-series-a .ct-bar, .ct-series-a .ct-line, .ct-series-a .ct-point, .ct-series-a .ct-slice-donut {
            stroke: lightseagreen;
            stroke-linecap: circle;
        }
    </style>
@endsection

@section('javascript-metrics')
    <script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
@endsection

@prepend('javascript-metrics-items')
    <script>
        var data_{{ md5($metric->uriKey) }} = {
            // A labels array that can contain any sort of values
            labels: [{!! $metric->labels !!}],
            // Our series array that contains series objects or in this case series data arrays
            series: [
                [{{ rand(0, 20) }}, {{ rand(0, 20) }}, {{ rand(0, 20) }}, {{ rand(0, 20) }}, {{ rand(0, 20) }}, {{ rand(0, 20) }}, {{ rand(0, 20) }}]
            ],
        };

        // Create a new line chart object where as first parameter we pass in a selector
        // that is resolving to our chart container element. The Second parameter
        // is the actual data object.
        new Chartist.Line('.{{ $metric->uriKey }}', data_{{ md5($metric->uriKey) }}, {
            showArea: true,
            low: 0,
        });
    </script>
@endprepend
