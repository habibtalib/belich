{{-- Get the metatags --}}
@include('belich::partials.headers.metatags')

{{-- Get the css --}}
@include('belich::partials.headers.styles')

@if(config('belich.turbolinks'))
    {{-- Load the vendor's scripts from webpack --}}
    @mix('app-tl.js')

    {{-- Load all the custom js --}}
    @include('belich::dashboard.javascript.default')
@endif
