@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.breadcrumbs')

    {{-- Search --}}
    <div class="table-search flex items-center">
        <div class="icon-search w-full">
            <input type="text" name="_search" id="_search" placeholder="search..." onkeydown="showResetSearch()">
            <span class="hidden" id="icon-search-reset">
                <i class="fas fa-times-circle text-grey cursor-pointer" onclick="resetSearch()"></i>
            </span>
        </div>

        {{-- Buttons --}}
        <div class="flex w-full justify-end">
            <a href="#" class="btn btn-primary">
                @icon('plus-square', 'belich::buttons.crud.create')
            </a>
        </div>
    </div>

    {{-- Start / Table --}}
    <form name="form-index" id="form-index" method="POST" action="">
        <table class="table">
            <thead>
                <tr>
                    <th><input type="checkbox" name="item_selection" onclick="checkAll('form-index', this)"></th>
                    @foreach($fields as $field)
                        <th>
                            {{-- Get URL with ASC or DESC order --}}
                            {!! Belich::blade()->getUrlWithOrder($field) !!}
                        </th>
                    @endforeach
                    <th></th>
                </tr>
            </thead>
            <tbody>
                {{-- Get the results --}}
                @forelse($results as $result)
                    <tr>
                        <td><input type="checkbox" name="item_selection[]" value="{{ $result->id }}"></td>
                        @foreach($fields as $field)
                            <td>
                                {{-- Resolve the values --}}
                                {{ Belich::blade()->resolveField($field, $result) }}
                            </td>
                        @endforeach
                        <td class="text-right">
                            {{-- Load the button actions --}}
                            {!! Belich::actions($result, $actions) !!}
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
            @if($pagination = $results->links())
                <tfoot>
                    <tr>
                        <td colspan="{{ $totalResults }}" class="text-center">{{ $pagination }}</td>
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
