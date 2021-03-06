{{-- Direct version using Blade components --}}
@component('belich::components.card')
    @slot('card', $card)
    @slot('content')
        <h1>Lorem</h1>
        <div>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
        </div>
    @endslot
@endcomponent

{{-- Same example using BladeX (https://github.com/spatie/laravel-blade-x) --}}
<belich::card :card="$card">
    <slot name="content">
        <h1>Lorem</h1>
        <div>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
        </div>
    </slot>
</belich::card>

{{-- Or just use your own code... --}}
