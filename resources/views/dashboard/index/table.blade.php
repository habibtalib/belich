{{-- Start / Table --}}
<table class="w-full text-sm bg-white text-gray-600 shadow-md {{ $request->get('tableTextAlign') }}" id="belich-index-table">
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
                        <a href="#"
                            class="text-blue-600"
                            role="button"
                            {{-- LiveSearch --}}
                            onclick="javascript:liveSearch(
                                '{{ $request->search['query'] }}',
                                '{{ $request->search['page'] }}',
                                '{{ $field->attribute }}',
                                '{{ $request->search['direction'] === 'desc' ? 'asc' : 'desc' }}'
                            );"
                        >
                            {{-- Column title --}}
                            {!! $field->label !!}
                            {{-- Icons --}}
                            @if($request->search['orderBy'] !== strtolower($field->label))
                                {!! Helper::icon('sort', '', 'text-gray-500') !!}
                            @endif
                            @if($request->search['direction'] === 'asc' && $request->search['orderBy'] == strtolower($field->label))
                                {!! Helper::icon('sort-up', '', 'text-blue-600') !!}
                            @endif
                            @if($request->search['direction'] === 'desc' && $request->search['orderBy'] == strtolower($field->label))
                                {!! Helper::icon('sort-down', '', 'text-blue-600') !!}
                            @endif
                        </a>
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
    @include('belich::dashboard.index.pagination')

</table>
