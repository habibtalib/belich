<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="h-full font-sans antialiased">
    <head>
        {{-- Meta-tags --}}
        @include('belich::layout.metatags')

        {{-- Title --}}
        <title>{{ config('app.name') }}</title>

        {{-- Styles --}}
        @include('belich::layout.styles')
        {{-- Add Font-awesome --}}
        @if(config('belich.fontAwesome'))
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
                integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ"
                crossorigin="anonymous"
            >
        @endif
    </head>
    <body>
        <div id="app">
            {{-- Navbar --}}
            @includeWhen(Auth::check() && config('belich.navbar'), 'belich::partials.navbar')

            {{-- Application --}}
            <section class="wrap-container">
                @yield('content')
            </section>

            {{-- Include footer --}}
            @includeIf('belich::partials.footer')
        </div>

        {{-- Javascript and libs --}}
        @includeWhen(Auth::check(), 'belich::layout.scripts')
    </body>
</html>
