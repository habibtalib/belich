@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.navigation.breadcrumbs')

    {{-- Search container --}}
    <div id="belich-table-search" class="flex items-center rounded-t p-4 pr-6 shadow-md w-full">
        <div class="icon-search w-full">
            <input type="text" name="_search" id="_search" class="p-2 pl-8 my-2 ml-2 rounded border border-grey-light shadow-md w-64" placeholder="search..." onkeydown="showResetSearch()">
            <span class="hidden" id="icon-search-reset">
                <i class="fas fa-times-circle text-grey cursor-pointer" onclick="resetSearch()"></i>
            </span>
        </div>

        {{-- Right container --}}
        <div class="flex justify-end w-full">

            {{-- Buttons --}}
            @can('create', $request->autorizedModel)
                <a href="{{ Belich::actionRoute('create') }}" class="btn btn-secondary mr-2">
                    @icon('plus', 'belich::buttons.crud.create')
                </a>
            @endcan

            {{-- Options --}}
            @include('belich::partials.buttons.options')

            {{-- Export --}}
            @includeWhen(Belich::downloable(), 'belich::partials.buttons.exports')

            {{-- Delete --}}
            @include('belich::partials.buttons.delete')
        </div>
        {{-- End right container --}}
    </div>
    {{-- End search container --}}

    {{-- Start / Table --}}
    <table class="table" id="belich-index-table">
        <thead>
            <tr>
                {{-- Checkboxes --}}
                <th>
                    <input type="checkbox" name="item_selection" onclick="checkAll(this)">
                </th>
                {{-- Headers --}}
                @foreach($request->fields as $field)
                    <th>
                        {{-- Get URL with ASC or DESC order --}}
                        {!! Belich::html()->tableLink($field) !!}
                    </th>
                @endforeach
                {{-- Action column --}}
                <th></th>
            </tr>
        </thead>
        <tbody>
            {{-- Get the results --}}
            @forelse($request->results as $result)
                <tr>
                    <td><input type="checkbox" name="item_selection[]" value="{{ $result->id }}" class="belich-form-index-selector"></td>
                    {{-- <td> --}}
                        @foreach($request->fields as $field)
                            {{-- Resolve the values and create the <td></td> --}}
                            {!! Belich::html()->resolveRowWithSoftdeletingCreatingHtml($field, $result) !!}
                        @endforeach
                    {{-- </td> --}}
                    <td class="text-right">
                        {{-- Load the button actions --}}
                        {!! Belich::actions($result, $request->actions) !!}
                    </td>
                </tr>
            {{-- No results --}}
            @empty
                <tr>
                    <td colspan="{{ $request->total }}" class="text-center">
                        {{ trans('belich::messages.resources.no_results') }}
                    </td>
                </tr>
            @endforelse
        </tbody>

        {{-- Pagination --}}
        @include('belich::partials.pagination')

    </table>

    {{-- End / Table --}}
    {{-- Table footer (bordered) --}}
    <div class="table-footer rounded-b-lg h-1 mb-16 shadow-md"></div>
@endsection

@section('javascript')
    <script>
        {{-- Check all checkboxes --}}
        function checkAll(selector) {
            var checkboxes = document.getElementById('belich-index-table').getElementsByTagName('input');
            for (var i=0; i < checkboxes.length; i++)  {
                if (checkboxes[i].type == 'checkbox')   {
                    checkboxes[i].checked = (selector.checked === true) ? true : false;
                }
            }
        }

        {{-- Search fields --}}
        function resetSearch() {
            document.getElementById('_search').value = '';
            document.getElementById('icon-search-reset').classList.add('hidden');
        }
        function showResetSearch() {
            if(document.getElementById('_search').value.length > 0) {
                return document.getElementById('icon-search-reset').classList.remove('hidden');
            }
        }

        {{-- Add checked checkboxes to hidden field --}}
        function addCheckboxesToField(fieldID) {
            return document.getElementById(fieldID).value = getCheckboxSelected();
        }
        function getCheckboxSelected() {
            var listOfCheckedElements = [];
            var elements = document.querySelector('#belich-index-table').querySelectorAll('input[type="checkbox"]');
            for (var i = 0; i < elements.length; i++) {
                if(elements[i].checked) {
                    listOfCheckedElements[i] = elements[i].value;
                }
            }
            return listOfCheckedElements;
        }

        {{-- Delete selected fields --}}
        function deleteSelectedFields(fieldID) {
            //Add selected values
            document.getElementById(fieldID).value = getCheckboxSelected();
            //Submit form and delete values
            document.getElementById('belich-form-delete-selected').submit();
        }
    </script>
@endsection
