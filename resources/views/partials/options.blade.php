{{-- Options --}}
<div class="btn btn-icon btn-dropdown">
    @icon('cogs')
    <form method="GET" class="btn-dropdown-content text-grey-dark text-left">
        @csrf

        {{-- Per page --}}
        @component('belich::components.dropdown-option')
            @slot('text', 'Per page')
            @slot('icon', 'exchange-alt')
            @slot('field', 'perPage')
            @slot('options', [10, 20, 30, 40, 50, 100])
        @endcomponent

        {{-- Trashed --}}
        @can('withTrashed', $request->autorizedModel)
            @component('belich::components.dropdown-option')
                @slot('text', 'Trashed')
                @slot('icon', 'trash-restore')
                @slot('field', 'withTrashed')
                @slot('options', [
                    ['all' => 'All'],
                    ['only' => 'Only trashed'],
                ])
            @endcomponent
        @endcan

        {{-- Export --}}
        <div class="w-full mb-1">
            @component('belich::components.dropdown-option')
                @slot('text', 'Export')
                @slot('icon', 'file-download')
                @slot('field', 'export')
                @slot('options', [
                    ['csv' => 'CSV'],
                    ['xls' => 'Excel'],
                    ['pdf' => 'Pdf'],
                ])
            @endcomponent
        </div>
    </form>
</div>
