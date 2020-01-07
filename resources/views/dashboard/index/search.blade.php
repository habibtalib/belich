<div id="belich-table-search" class="w-full flex items-center">

    {{-- Search field --}}
    <div class="icon-search w-full relative">
        <input type="text" name="search-{{ Belich::key() }}" id="search-{{ Belich::key() }}" data-search="" class="p-2 pl-10 my-2 ml-2 rounded-lg border bg-gray-200 w-64 text-gray-700 appearance-none leading-normal ds-input" placeholder="@lang('belich::default.search')" onkeyup="javascript:liveSearch('{{ Belich::key() }}', this.value);" onkeydown="javascript:showResetSearch('{{ Belich::key() }}')">
        <span>
            <i class="fas fa-search text-gray-600 absolute inset-y-0 left-0 pl-5 pt-5"></i>
        </span>
        <span class="hidden" id="icon-search-reset-{{ Belich::key() }}">
            <i class="fas fa-times-circle cursor-pointer text-gray-500" onclick="resetSearch('{{ Belich::key() }}')"></i>
        </span>
    </div>

    {{-- Right container --}}
    <div class="flex justify-end w-full">

        {{-- Buttons: create --}}
        @can('create', $request->autorizedModel)
            <belich::button
                :title="Helper::icon('plus', trans('belich::buttons.crud.create'))"
                :url="Belich::actionRoute('create')"
                class="mx-2"
                color="secondary"
                dusk="table-create-button"
                loading
            />
        @endcan

        {{-- Dropdowns --}}
        {{-- Dropdown: Options --}}
        @include('belich::partials.buttons.options')

        {{-- Show or hide base on selected items --}}
        {{-- Dropdown: Export --}}
        @includeWhen(Belich::downloable(), 'belich::partials.buttons.exports')

        {{-- Dropdown: Delete --}}
        @can('delete', $request->autorizedModel)
            @include('belich::partials.buttons.delete')
        @endcan

    </div>
    {{-- End right container --}}
</div>
{{-- End search container --}}
