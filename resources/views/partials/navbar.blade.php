<nav id="navbar">
    {{-- Multilevel top navigation --}}
    @if(config('belich.navbar') === 'top')
        {!! Belich::navbar() !!}
    @endif

    {{-- Simple level top navigation and sidebar for second navigation --}}
    @if(config('belich.navbar') === 'full')
        {{-- Include for first navigation level --}}
        {!! Belich::navbar() !!}

        {{-- Include sidebar for second navigation level --}}
        @include('belich::partials.sidebar')
    @endif
</nav>

