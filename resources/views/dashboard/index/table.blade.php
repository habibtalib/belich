{{-- Start / Table --}}
<div id="tableContainer">
    <table class="table table-auto w-full text-sm text-left shadow-md bg-white text-gray-600" id="belich-index-table">
        <thead class="uppercase">
            <tr class="border-b border-t border-gray-400 bg-blue-100 text-gray-600">

                {{-- Checkboxes --}}
                <th class="pt-4 pb-5 px-6">
                    <input type="checkbox" name="item_selection" onclick="checkAll(this)">
                </th>

                {{-- Headers --}}
                @foreach($request->fields->get('labels') as $label)
                    <th class="pt-4 pb-5 px-6">
                        {{-- Get URL with ASC or DESC order --}}
                        {!! $label !!}
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
                    <td class="py-4 px-6 border-b border-solid border-gray-200"><input type="checkbox" name="item_selection[]" value="{{ $result->id }}" class="form-index-selector" onclick="checkForSelectedFields();"></td>

                    {{-- Get the values --}}
                    @foreach($request->fields->get('data') as $field)
                        <td class="py-4 px-6 border-b border-solid border-gray-200 {!! Belich::html()->resolveSoftdeleting($field, $result) ? 'text-red-500 line-through' : 'no-softdeleted' !!}">
                            @if($field->asHtml)
                                {!! Belich::html()->resolve($field, $result) !!}
                            @else
                                {{ Belich::html()->resolve($field, $result)}}
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
                    <td colspan="{{ $request->total }}" class="text-center">
                        {{ trans('belich::messages.resources.no_results') }}
                    </td>
                </tr>
            @endforelse
        </tbody>

        {{-- Pagination --}}
        @include('belich::dashboard.index.pagination')

    </table>
</div>
