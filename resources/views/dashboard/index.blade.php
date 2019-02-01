@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.breadcrumbs')

    {{-- Search --}}
    <div class="table-search flex items-center">
        <div class="icon-search">
            <input type="text" name="_search" id="_search" placeholder="search..." onkeydown="showResetSearch()">
            <span class="hidden" id="icon-search-reset">
                <i class="fas fa-times-circle text-grey cursor-pointer" onclick="resetSearch()"></i>
            </span>
        </div>
        <div class="flex w-full justify-end items-center"></div>
        <div>
            <button class="btn btn-primary">Hellow</button>
        </div>
    </div>

    {{-- Start / Table --}}
    <form name="form-index" id="form-index" method="POST" action="">
        <table class="table">
            <thead>
                <tr>
                    <th><input type="checkbox" name="item_selection" onclick="checkAll('form-index', this)"></th>
                    @foreach($resource['fields'] as $field)
                        <th>
                            {!! Utils::urlWithOrder($field) !!}
                        </th>
                    @endforeach
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($resource['results'] as $item)
                    <tr>
                        <td><input type="checkbox" name="item_selection[]" value="{{ $item->id }}"></td>
                        @foreach($resource['fields'] as $field)
                            <td>
                                {{ Utils::value($item, $field->attribute) }}
                            </td>
                        @endforeach
                        <td>
                            {{ Belich::actions($resource) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ Utils::count($resource['fields']['labels']) + 2 }}" class="text-center">
                            {{ trans('belich::messages.resources.no_results') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
            @if($pagination = $resource['results']->links())
                <tfoot>
                    <tr>
                        <td colspan="{{ Utils::count($resource['fields']) + 2 }}" class="text-center">{{ $pagination }}</td>
                    </tr>
                </tfoot>
            @endif
        </table>
    </form>
    {{-- End / Table --}}
    {{-- Table footer --}}
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
