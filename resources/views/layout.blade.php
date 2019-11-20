<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="h-full font-sans antialiased">
    <head>
        {{-- All the metatags, css, js,... --}}
        @include('belich::partials.headers.default')
    </head>
    <body>
            {{-- Top navbar --}}
            @if(config('belich.navbar.display') === 'top')
                <div id="app">
                    {{-- Navbar --}}
                    @includeWhen(auth()->check(), 'belich::partials.navigation.navbar')
                    {{-- Sidebar and Application container --}}
                    <div class="w-full min-h-screen">
                        {{-- Messages --}}
                        @include('belich::partials.messages')
                        {{-- Application --}}
                        @yield('content')
                    </div>
                </div>
            {{-- Sidebar --}}
            @else
                <div id="app" class="flex">
                    <div class="flex-initial w-64">
                        @include('belich::partials.navigation.sidebar')
                    </div>
                    <div class="flex-initial w-full bg-white">
                        {{-- Navbar --}}
                        @includeWhen(auth()->check(), 'belich::partials.navigation.navbar')
                        {{-- Messages --}}
                        @include('belich::partials.messages')
                        {{-- Application --}}
                        @yield('content')
                    </div>
                </div>
            @endif

            {{-- Add modals --}}
            @stack('modals')

        {{-- Include footer --}}
        <footer>
            @include('belich::partials.footer.content')
            @include('belich::partials.footer.javascript')
        </footer>
    </body>
</html>
