{{-- Start / Table --}}
<table class="table table-auto" id="belich-index-table">
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
                <td><input type="checkbox" name="item_selection[]" value="{{ $result->id }}" class="form-index-selector" onclick="checkForSelectedFields();"></td>
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
