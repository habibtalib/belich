{{-- Fonts --}}
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,800,800i,900,900i" rel="stylesheet" media="all">

{{-- Vendor --}}
@if (App::environment('local'))
    <link href="/vendor/belich/app.css" rel="stylesheet" media="all">
@else
    @mix('app.css')
@endif

{{-- Css metrics --}}
@hasMetrics($request ?? null)
    {{-- Load the css lib --}}
    {!! Chart::assets('css') !!}
@endif

@stack('css')
