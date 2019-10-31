@if(session()->has('success') || session()->has('errors'))
    <div class="flex justify-center w-full leading-normal mt-4 mb-8">
        {{-- Success --}}
        @if(session()->has('success'))
            <belich::message
                color="green"
                type="success"
                icon="check"
                :title="session()->get('header') ?? trans('belich::messages.crud.success.title')"
            />
        @endif

        {{-- Errors --}}
        @if(session()->has('errors'))
            <belich::message
                color="red"
                type="errors"
                icon="hand-paper"
                :title="session()->get('header') ?? trans('belich::messages.crud.fail.title')"
            />
        @endif
    </div>
@endif
