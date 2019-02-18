<div class="flex justify-center w-full leading-normal mb-8">
    @if(session()->has('success'))
        @component('belich::components.message')
            @slot('message_color', 'teal')
            @slot('message_icon', 'check')
            @slot('message_header', session()->get('message_header'))
            @slot('message_bag', session()->get('success'))
        @endcomponent
    @endif

    @if(session()->has('errors'))
        @component('belich::components.message')
            @slot('message_color', 'red')
            @slot('message_icon', 'exclamation-triangle')
            @slot('message_header', session()->get('message_header'))
            @slot('message_bag', session()->get('errors')->all())
        @endcomponent
    @endif
</div>
