@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.navigation.breadcrumbs')

    {{-- Metrics --}}
    <div class="{{ hideMetricsForScreens($request) }}">
        {!! Chart::render($request) !!}
    </div>

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
            {{-- Buttons: create --}}
            @can('create', $request->autorizedModel)
                <a href="{{ Belich::actionRoute('create') }}" class="btn btn-secondary mr-2">
                    @icon('plus', 'belich::buttons.crud.create')
                </a>
            @endcan
            {{-- Dropdowns --}}
            {{-- Dropdown: Options --}}
            @include('belich::partials.buttons.options')
            {{-- Show or hide base on selected items --}}
            {{-- Dropdown: Export --}}
            @includeWhen(Belich::downloable(), 'belich::partials.buttons.exports')
            {{-- Dropdown: Delete --}}
            @include('belich::partials.buttons.delete')
        </div>
        {{-- End right container --}}
    </div>
    {{-- End search container --}}

    {{-- Table --}}
    @include('belich::dashboard.sections.table')

    {{-- End / Table --}}
    {{-- Table footer (bordered) --}}
    <div class="table-footer rounded-b-lg h-1 mb-16 shadow-md"></div>
@endsection

{{-- Added the minimum javascript possible --}}
@prepend('javascript')
    @include('belich::dashboard.javascript.index')
@endprepend

{{-- Added the modals --}}
@prepend('modals')
    {{-- Modal component: delete item --}}
    <belich::modal form="true" id="item-delete" background="red" color="white" action="#" :request="$request" :header="icon('exclamation-triangle', trans('belich::messages.delete.item.title'))">
        {{-- Form method field for DELETE --}}
        <slot name="method">
            @method('DELETE')
        </slot>
        {{-- Modal content --}}
        <slot name="content">
            <div>@listTextFromArray('belich::messages.delete.item.confirm')</div>
        </slot>
        {{-- Modal footer --}}
        <slot name="footer">
            <a href="#" class="btn btn-default mx-2 close">@lang('belich::buttons.actions.cancel')</a>
            <button class="btn btn-success mx-2">@lang('belich::buttons.actions.confirm')</button>
        </slot>
    </belich::modal>
@endprepend
