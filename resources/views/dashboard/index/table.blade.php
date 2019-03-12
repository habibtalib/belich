{{-- Start / Table --}}
<table class="table table-auto w-full text-sm text-left shadow-md bg-white text-grey-dark" id="belich-index-table">
    <thead class="uppercase">
        <tr class="border-b border-t border-grey-light bg-blue-lightest text-grey-dark">
            {{-- Checkboxes --}}
            <th class="pt-4 pb-5 px-6">
                <input type="checkbox" name="item_selection" onclick="checkAll(this)">
            </th>
            {{-- Headers --}}
            @foreach($request->fields as $field)
                <th class="pt-4 pb-5 px-6">
                    {{-- Get URL with ASC or DESC order --}}
                    {!! Belich::html()->tableLink($field) !!}
                </th>
            @endforeach
            {{-- Action column --}}
            <th class="pt-4 pb-5 px-6"></th>
        </tr>
    </thead>
    <tbody>
        {{-- Get the results --}}
        @forelse($request->results as $result)
            <tr class="hover:bg-grey-lightest">
                <td class="py-4 px-6 border-b border-solid border-grey-lighter"><input type="checkbox" name="item_selection[]" value="{{ $result->id }}" class="form-index-selector" onclick="checkForSelectedFields();"></td>

                {{-- Get the values --}}
                @foreach($request->fields as $field)
                    {{-- Resolve the values --}}
                    <td class="py-4 px-6 border-b border-solid border-grey-lighter {!! Belich::html()->resolveSoftdeleting($field, $result) ? 'text-red line-through' : 'no-softdeleted' !!}">
                        @if($field->asHtml)
                            {!! Belich::html()->resolve($field, $result) !!}
                        @else
                            {{ Belich::html()->resolve($field, $result)}}
                        @endif
                    </td>
                @endforeach

                <td class="text-right py-4 px-6 border-b border-solid border-grey-lighter">
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
    @include('belich::dashboard.index.pagination')

</table>
