{{-- Start / Table --}}
<table class="w-full text-sm bg-white text-gray-600 shadow-md index-table {{ $request->get('tableTextAlign') }}" id="index-table-{{ Belich::key() }}">
    <thead class="uppercase">
        <tr class="border-b border-t border-gray-300 bg-blue-100 text-gray-600">

            {{-- Checkboxes --}}
            <th class="pt-4 pb-5 px-6">
                <input type="checkbox" name="item_selection" onclick="checkAll(this)" dusk="index-table-select-all">
            </th>

            {{-- Headers --}}
            @foreach($request->fields->get('data') as $field)
                <th class="pt-4 pb-5 px-6">
                    {{-- Get URL with ASC or DESC order --}}
                    {{-- Sortable column --}}
                    @if($field->sortable && is_string($field->attribute))
                        <button type="button"
                            class="button-clickable text-blue-600 uppercase font-bold"
                            role="button"
                            {{-- LiveSearch --}}
                            onclick="javascript:liveSearch(
                                '{{ Belich::key() }}',
                                '{{ $request->search['query'] ?? '' }}',
                                '{{ $request->search['page'] ?? '' }}',
                                '{{ $field->attribute }}',
                                '{{ isset($request->search) && $request->search['direction'] === 'desc' ? 'asc' : 'desc' }}'
                            );"
                        >
                            {{-- Column title --}}
                            {!! $field->label !!}
                            {{-- Icons --}}
                            @if(isset($request->search) && $request->search['orderBy'] !== strtolower($field->label))
                                {!! Helper::icon('b-sort', '', 'text-gray-500') !!}
                            @endif
                            @if(isset($request->search) && $request->search['direction'] === 'asc' && $request->search['orderBy'] == strtolower($field->label))
                                {!! Helper::icon('b-up', '', 'text-blue-400') !!}
                            @endif
                            @if(isset($request->search) && $request->search['direction'] === 'desc' && $request->search['orderBy'] == strtolower($field->label))
                                {!! Helper::icon('b-down', '', 'text-blue-400') !!}
                            @endif
                        </button>
                    {{-- Not sortable --}}
                    @else
                        {!! $field->label !!}
                    @endif
                </th>
            @endforeach

            {{-- Action column --}}
            <th class="pt-4 pb-5 px-6"></th>
        </tr>
    </thead>
    <tbody>
        {{-- Get the results --}}
        @forelse($request->results as $result)
            <tr class="hover:bg-gray-100">
                <td class="py-4 px-6 border-b border-solid border-gray-200"><input type="checkbox" name="item_selection[]" value="{{ $result->id }}" dusk="index-table-select-{{ $result->id }}" class="form-index-selector" onclick="checkForSelectedFields();"></td>

                {{-- Get the values --}}
                @foreach($request->fields->get('data') as $field)
                    <td class="py-4 px-6 border-b border-solid border-gray-200 {!! Helper::hasSoftdeletedResults($result) ? 'text-red-500 line-through' : 'no-softdeleted' !!}">
                        @if($field->asHtml)
                            {!! Belich::value($field, $result) !!}
                        @else
                            {{ Belich::value($field, $result)}}
                        @endif
                    </td>
                @endforeach

                {{-- Get the button actions --}}
                <td class="text-right py-4 px-6 border-b border-solid border-gray-200">
                    {!! Belich::actions($result, $request->actions) !!}
                </td>
            </tr>

        {{-- No results --}}
        @empty
            <tr>
                <td colspan="{{ $request->total }}" class="text-center p-4 text-lg">
                    {{ trans('belich::messages.resources.no_results', ['resource' => strtoupper(Belich::resource())]) }}
                </td>
            </tr>
        @endforelse
    </tbody>

    {{-- Pagination --}}
    @if($request->results->hasPages())
        <tfoot class="bg-blue-100 shadow-md">
            <tr>
                <td colspan="{{ $request->total }}" class="text-center">
                    <div id="{{ config('belich.pagination') === 'link' ? 'link-pagination' : 'simple-pagination' }}">
                        {!! $request->results->links('belich::dashboard.index.pagination', ['search' => $request->search]) !!}
                    </div>
                </td>
            </tr>
        </tfoot>
    @endif
</table>
