{{-- Fonts --}}
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,800,800i,900,900i" rel="stylesheet">

{{-- Vendor --}}
@mix('app.css')

{{-- Css metrics --}}
@ifMetrics($request ?? null)
    {{-- Load the css lib --}}
    {!! Metric::assets('css') !!}
    {{-- Load the custom css styles for the lib --}}
    <style>
        .ct-series-a .ct-bar, .ct-series-a .ct-line, .ct-series-a .ct-point, .ct-series-a .ct-slice-donut {
            stroke: lightseagreen;
            stroke-linecap: circle;
        }
    </style>
@endif
