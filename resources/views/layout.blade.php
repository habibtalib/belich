<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="h-full font-sans antialiased">
    <head>
        {{-- Meta-tags --}}
        @include('belich::layout.metatags')

        {{-- Title --}}
        <title>{{ config('app.name') }}</title>

        {{-- Styles --}}
        @include('belich::layout.styles')
    </head>
    <body>
        {{-- Navbar --}}
        <header>
            @include('belich::partials.navbar')
        </header>

        {{-- Include the sidebar if exists... --}}
        @includeIf('belich::partials.sidebar')

        <section id="app" class="wrap-container">
            @yield('content')
        </section>

        {{-- Include footer --}}
        @includeIf('belich::partials.footer')

        {{-- Javascript and libs --}}
        @include('belich::layout.scripts')
    </body>
</html>
