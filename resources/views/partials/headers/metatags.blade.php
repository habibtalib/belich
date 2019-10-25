{{-- Title --}}
<title>{{ config('app.name') }}</title>

{{-- Metatags --}}
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="robots" content="index, follow">

@if(config('belich.turbolinks'))
    @hasMetrics($request ?? null)
        <meta name="turbolinks-visit-control" content="reload">
    @endif
@endif
