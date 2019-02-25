{{-- Fonts --}}
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,800,800i,900,900i" rel="stylesheet">

{{-- Vendor --}}
@mix('app.css')

{{-- Css metrics --}}
@hasMetrics($request ?? null)
    {{-- Load the css lib --}}
    {!! Chart::assets('css') !!}
@endif
