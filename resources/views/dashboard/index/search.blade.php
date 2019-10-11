<div id="belich-table-search" class="flex items-center">

    {{-- Search field --}}
    <div class="icon-search w-full">
        <input type="text" name="_search" id="_search" class="p-2 pl-8 my-2 ml-2 rounded border border-gray-400 shadow-md w-64" placeholder="search..." onkeydown="showResetSearch()">
        <span class="hidden" id="icon-search-reset">
            <i class="fas fa-times-circle text-gray-500 cursor-pointer" onclick="resetSearch()"></i>
        </span>
    </div>

    {{-- Right container --}}
    <div class="flex justify-end w-full">

        {{-- Buttons: create --}}
        @can('create', $request->autorizedModel)
            <belich::button
                :title="icon('plus', trans('belich::buttons.crud.create'))"
                :url="Belich::actionRoute('create')"
                class="mx-2"
                color="secondary"
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

@push('jquery')
    <script>
        function liveSearch(query = '')
        {
            //Min. search filter
            if(query.length < 2) {
                return;
            }

            $.ajax({
                url: "{{ route('dashboard.ajax.search') }}",
                method: 'GET',
                data: {
                    query: query,
                    resourceName: '{{ Belich::resourceName() }}',
                    type: 'search',
                    fields: '{{ Belich::searchFields() }}'
                },
                dataType: 'json',
                success: function(data) {
                    // $('tbody').html(data.table_data);
                    // $('#total_records').text(data.total_data);
                    console.log(data);
                }
            })
        }

        $(function() {
            $(document).on('keyup', '#_search', function(event) {
                event.preventDefault();
                liveSearch($(this).val());
            });
        });
    </script>
@endpush
