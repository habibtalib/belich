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
        <div id="app">
            {{-- Navbar --}}
            @includeWhen(config('belich.navbar'), 'belich::partials.navbar')

            {{-- Sidebar --}}
            @includeWhen(config('belich.sidebar'), 'belich::partials.sidebar')

            {{-- Application --}}
            <section class="wrap-container">
                @yield('content')
            </section>

            {{-- Include footer --}}
            @includeIf('belich::partials.footer')
        </div>

        {{-- Javascript and libs --}}
        @include('belich::layout.scripts')
    </body>
</html>
