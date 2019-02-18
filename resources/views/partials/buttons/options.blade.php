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
        action="/"
    >
        @csrf

        {{-- Per page --}}
        @component('belich::components.options')
            @slot('css', 'rounded-t-lg')
            @slot('text', 'Per page')
            @slot('icon', 'exchange-alt')
            @slot('field', 'perPage')
            @slot('options', [10, 20, 30, 40, 50, 100])
        @endcomponent

        {{-- Trashed --}}
        @can('withTrashed', $request->autorizedModel)
            @component('belich::components.options')
                @slot('text', 'Trashed')
                @slot('icon', 'trash-restore')
                @slot('field', 'withTrashed')
                @slot('options', [
                    ['all' => 'All'],
                    ['only' => 'Only trashed'],
                ])
            @endcomponent
        @endcan

        <div class="float-right p-2 mb-2">
            <button type="submit" class="btn btn-default">{!! icon('redo-alt', 'Configure') !!}</button>
        </div>
    </form>
</div>
