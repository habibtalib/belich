@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.breadcrumbs')

    {{-- Search --}}
    <div id="table-search" class="flex items-center rounded-t p-4 pr-6 shadow-md w-full">
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
            <div class="btn btn-icon btn-dropdown">
                @icon('cogs')
                <form method="GET" class="btn-dropdown-content text-grey-dark text-left">
                    @csrf
                    <div class="w-full mb-1">
                        <div class="w-full p-4 bg-grey-lighter border-b border-grey-light">Per page</div>
                        <div class="p-2 text-lg">
                            <select name="perPage" class="w-full h-10">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    <div class="w-full mb-1">
                        <div class="w-full p-4 bg-grey-lighter border-t border-b border-grey-light">Per page</div>
                        <div class="p-2 text-lg">
                            <select name="perPage" class="w-full h-10">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
    </div>
    </div>

    {{-- Start / Table --}}
    <form name="form-index" id="form-index" method="POST" action="">
        <table class="table">
            <thead>
                <tr>
                    <th><input type="checkbox" name="item_selection" onclick="checkAll('form-index', this)"></th>
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
                        <td><input type="checkbox" name="item_selection[]" value="{{ $result->id }}"></td>
                        @foreach($request->fields as $field)
                            {{-- Resolve the values and create the <td></td> --}}
                            {!! Belich::html()->resolveRowWithSoftdeletingCreatingHtml($field, $result) !!}
                        @endforeach
                        <td class="text-right">
                            {{-- Load the button actions --}}
                            {!! Belich::actions($result, $request->actions) !!}
                        </td>
                    </tr>
                {{-- No results --}}
                @empty
                    <tr>
                        <td colspan="{{ $totalResults }}" class="text-center">
                            {{ trans('belich::messages.resources.no_results') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>

            {{-- Pagination --}}
            @if($pagination = $request->results->links())
                <tfoot>
                    <tr>
                        <td colspan="{{ $request->total }}" class="text-center">{{ $pagination }}</td>
                    </tr>
                </tfoot>
            @endif

        </table>
    </form>
    {{-- End / Table --}}
    {{-- Table footer (bordered) --}}
    <div class="table-footer rounded-b-lg h-1 mb-16 shadow-md"></div>
@endsection

@section('javascript')
    <script>
        function checkAll(formName, selector) {
            var checkboxes = document[formName].getElementsByTagName('input');
            for (var i=0; i < checkboxes.length; i++)  {
                if (checkboxes[i].type == 'checkbox')   {
                    checkboxes[i].checked = (selector.checked === true) ? true : false;
                }
            }
        }
        function resetSearch() {
            document.getElementById('_search').value = '';
            document.getElementById('icon-search-reset').classList.add('hidden');
        }
        function showResetSearch() {
            if(document.getElementById('_search').value.length > 0) {
                return document.getElementById('icon-search-reset').classList.remove('hidden');
            }
        }
    </script>
@endsection
