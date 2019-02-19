{{-- Options --}}
<div class="btn btn-dropdown border border-grey mr-2 bg-grey-lighter text-grey-dark hover:bg-grey hover:text-white">
    {{-- Set button icon --}}
    @icon('cogs', '', 'opacity-100')

    {{-- Start with form --}}
    <form method="POST"
        name="belich-form-options"
        id="belich-form-options"
        dusk="dusk-form-options"
        class="btn-dropdown-content pin-r rounded-lg border border-grey shadow text-grey-dark text-left bg-white"
        action="{{ route('dashboard.users.settings') }}"
    >
        @csrf

        {{-- Per page --}}
        @component('belich::components.options')
            @slot('css', 'rounded-t-lg')
            @slot('text', trans('belich::default.perPage'))
            @slot('field', 'perPage')
            @slot('options', [10, 20, 30, 40, 50, 100])
        @endcomponent

        {{-- Trashed --}}
        @can('withTrashed', $request->autorizedModel)
            @component('belich::components.options')
                @slot('text', trans('belich::default.trashed'))
                @slot('field', 'withTrashed')
                @slot('options', [
                    ['none' => trans('belich::default.none')],
                    ['all'  => trans('belich::default.all')],
                    ['only' => trans('belich::default.trashedOnly')],
                ])
            @endcomponent
        @endcan

        <div class="float-right p-2 mb-2">
            <button type="submit" class="btn btn-default">{!! icon('redo-alt', trans('belich::buttons.base.configure')) !!}</button>
        </div>
    </form>
</div>
