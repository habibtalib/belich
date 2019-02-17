<div class="flex justify-center w-full leading-normal mb-8">
    @if(session()->has('success'))
        @component('belich::components.message')
            @slot('color', 'green')
            @slot('messages', session()->get('success'))
        @endcomponent
    @endif

    @if(session()->has('errors'))
        @component('belich::components.message')
            @slot('color', 'red')
            @slot('messages', session()->get('errors')->all())
        @endcomponent
    @endif
</div>
