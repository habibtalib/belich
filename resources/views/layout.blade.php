<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="h-full font-sans antialiased">
    <head>
        {{-- All the metatags, css, js,... --}}
        @include('belich::partials.headers.default')
    </head>
    <body>
        <div id="app">
            {{-- Navbar --}}
            @includeWhen(auth()->check(), 'belich::partials.navigation.navbar')

            {{-- Sidebar and Application container --}}
            <div class="min-h-screen md:flex">
                {{-- Sidebar --}}
                @includeWhen(auth()->check() && config('belich.navbar') === 'sidebar', 'belich::partials.navigation.sidebar')

                {{-- Application --}}
                <section class="flex-1 m-8">
                    @include('belich::partials.messages')
                    @yield('content')
                </section>
            </div>

            {{-- Add modals --}}
            @stack('modals')
        </div>

        {{-- Include footer --}}
        @include('belich::partials.footer.default')
    </body>
</html>
