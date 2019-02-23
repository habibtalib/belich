<div class="flex justify-center w-full leading-normal mb-8">
    @if(session()->has('success'))
        @component('belich::components.message')
            @slot('color', 'teal')
            @slot('icon', 'check')
            @slot('header', session()->get('header') ?? trans('belich::messages.crud.success.title'))
            @slot('messages', session()->get('success'))
        @endcomponent
    @endif

    @if(session()->has('errors'))
        @component('belich::components.message')
            @slot('color', 'red')
            @slot('icon', 'exclamation-triangle')
            @slot('header', session()->get('header') ?? trans('belich::messages.crud.fail.title'))
            @slot('messages', session()->get('errors')->all())
        @endcomponent
    @endif
</div>
