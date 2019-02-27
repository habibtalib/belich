<div id="belich-table-search" class="flex items-center">

    {{-- Search field --}}
    <div class="icon-search w-full">
        <input type="text" name="_search" id="_search" class="p-2 pl-8 my-2 ml-2 rounded border border-grey-light shadow-md w-64" placeholder="search..." onkeydown="showResetSearch()">
        <span class="hidden" id="icon-search-reset">
            <i class="fas fa-times-circle text-grey cursor-pointer" onclick="resetSearch()"></i>
        </span>
    </div>

    {{-- Right container --}}
    <div class="flex justify-end w-full">

        {{-- Buttons: create --}}
        @can('create', $request->autorizedModel)
            <a href="{{ Belich::actionRoute('create') }}" class="btn btn-secondary mr-2">
                @icon('plus', 'belich::buttons.crud.create')
            </a>
        @endcan

        {{-- Dropdowns --}}

        {{-- Dropdown: Options --}}
        @include('belich::partials.buttons.options')
        {{-- Show or hide base on selected items --}}
        {{-- Dropdown: Export --}}
        @includeWhen(Belich::downloable(), 'belich::partials.buttons.exports')
        {{-- Dropdown: Delete --}}
        @include('belich::partials.buttons.delete')

    </div>
    {{-- End right container --}}
</div>
{{-- End search container --}}