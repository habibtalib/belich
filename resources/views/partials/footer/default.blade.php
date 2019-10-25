<footer>
    @if(config('belich.turbolinks') == false)
        {{-- Load the vendor's scripts from webpack --}}
        @mix('app.js')

        {{-- Load all the custom js --}}
        @include('belich::dashboard.javascript.default')
    @endif
</footer>
