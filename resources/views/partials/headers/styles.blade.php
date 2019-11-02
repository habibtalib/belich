{{-- Fonts --}}
<link rel="dns-prefetch" href="//fonts.googleapis.com">
<link rel="dns-prefetch" href="//use.fontawesome.com">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,800,800i,900,900i" rel="stylesheet" media="all">
{{-- Add Font-awesome --}}
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
    integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ"
    crossorigin="anonymous"
>

{{-- Vendor from webpack --}}
@mix('app.css')

{{-- Stack of css --}}
@stack('css')

{{-- Not repeat css (only one) --}}
@yield('css-no-repeat')
