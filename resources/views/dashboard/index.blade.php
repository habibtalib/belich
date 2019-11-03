@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.navigation.breadcrumbs')

    {{-- Metrics And Cards --}}
    @if($request->metrics || $request->cards)
        <div class="{{ Helper::hideMetricsForScreens() }} flex-wrap mb-3">
            {!! Belich::components($request) !!}
        </div>
    @endif

    {{-- Search container --}}
    {{-- input: search field --}}
    {{-- buttons: options, export, delete,... --}}
    @if(config('belich.liveSearch.enable') === true)
        <div id="search-container" class="p-4 shadow-md bg-white">
            @include('belich::dashboard.index.search')
        </div>
    @endif

    {{-- Table --}}
    {{-- Pagination --}}
    <div id="table-container" class="w-full">
        @include('belich::dashboard.index.table')
    </div>
@endsection

{{-- Added the minimum javascript possible --}}
@push('javascript')
    @include('belich::dashboard.javascript.index')
@endpush

{{-- Added the minimum css possible --}}
@hasMetrics($request ?? null)
    @push('css')
        {{-- Load the css lib --}}
        {!! Chart::assets('css') !!}
    @endpush
@endif

{{-- Added the modals --}}
@push('modals')
    {{-- Modal component: delete item --}}
    <belich::modal form="true" id="item-delete" background="red-500" action="#" :request="$request" :header="icon('exclamation-triangle', trans('belich::messages.delete.item.title'))">

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
                onclick="submitForm(this);"
            />
        </slot>
    </belich::modal>
@endpush
