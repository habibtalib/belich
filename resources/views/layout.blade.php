<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="h-full font-sans antialiased">
    <head>
        {{-- Meta-tags --}}
        @include('belich::dashboard.headers.metatags')

        {{-- Title --}}
        <title>{{ config('app.name') }}</title>

        {{-- Styles --}}
        @include('belich::dashboard.headers.styles')

        {{-- Livewire --}}
        @livewireAssets

        {{-- Add Font-awesome --}}
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
            integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ"
            crossorigin="anonymous"
        >
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

            {{-- Include footer --}}
            @includeIf('belich::partials.footer')

            {{-- Add modals --}}
            @stack('modals')
        </div>

        {{-- Javascript and libs --}}
        @includeWhen(auth()->check(), 'belich::dashboard.headers.scripts')
    </body>
</html>
