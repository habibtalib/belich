@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.navigation.breadcrumbs')

    {{-- Metrics And Cards --}}
    <div id="metrics-and-cards">
        <div class="{{ hideMetricsForScreens() }}">
            {!! Chart::render($request) !!}
        </div>
{{--         <div class="{{ hideMetricsForScreens($request) }}">
            {!! Chart::render($request) !!}
        </div> --}}
    </div>

    {{-- Search container --}}
    {{-- input: search field --}}
    {{-- buttons: options, export, delete,... --}}
    <div id="search-container" class="p-4 pr-6 shadow-md bg-grey-lightest">
        @include('belich::dashboard.index.search')
    </div>

    {{-- Table --}}
    {{-- Pagination --}}
    <div id="table-container">
        @include('belich::dashboard.index.table')
    </div>

    {{-- End / Table --}}
    {{-- Table footer (bordered) --}}
    <div class="table-footer rounded-b-lg h-1 mb-16 shadow-md"></div>
@endsection

{{-- Added the minimum javascript possible --}}
@push('javascript')
    @include('belich::dashboard.javascript.index')
@endpush

{{-- Added the modals --}}
@push('modals')

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
            <belich::button
                :title="trans('belich::buttons.actions.cancel')"
                url="#"
                class="mx-2 close"
                color="default"
            />

            <belich::button
                color="success"
                :title="icon('trash', trans('belich::buttons.actions.confirm'))"
                loading
            />
        </slot>
    </belich::modal>
@endpush
