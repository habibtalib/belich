<div class="flex justify-center w-full leading-normal mb-8">
    {{-- Success --}}
    @if(session()->has('success'))
        <belich::message
            color="teal"
            icon="check"
            type="success"
            :header="trans('belich::messages.crud.success.title')"
        />
    @endif

    {{-- Errors --}}
    @if(session()->has('errors'))
        <belich::message
            color="red"
            icon="exclamation-triangle"
            type="errors"
            :header="trans('belich::messages.crud.fail.title')"
        />
    @endif
</div>
