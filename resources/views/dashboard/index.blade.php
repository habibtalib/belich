@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.navigation.breadcrumbs')

    {{-- Metrics --}}
    {!! Metric::render($request) !!}

    {{-- Search container --}}
    <div id="belich-table-search" class="flex items-center p-4 pr-6 shadow-md bg-grey-lightest w-full">
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

{{-- Added the minimum javascript possible --}}
@section('javascript')
    @include('belich::dashboard.javascript.index')
@endsection
