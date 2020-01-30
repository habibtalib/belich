{{-- Fonts --}}
<link rel="dns-prefetch" href="//fonts.googleapis.com">
<link rel="preconnect" href="//fonts.googleapis.com" crossorigin>
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,800,800i,900,900i" rel="stylesheet" media="all">

{{-- Add Icons --}}
{!! Helper::iconAssets() !!}

{{-- Vendor from webpack --}}
@mix('app.css')

{{-- Stack of css --}}
@stack('css')

@stack('css-metrics')

{{-- Not repeat css (only one) --}}
@yield('css-no-repeat')

{{-- Markdown: css and javascript (must be in the header) --}}
@yield('markdown')
