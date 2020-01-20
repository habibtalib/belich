{{-- Filters --}}
@if($filters = Belich::filters($request))
    <div id="filters-container" dusk="button-options-filters" class="btn btn-dropdown mr-2 bg-blue-300 rounded-lg text-white hover:bg-blue-500">
        {{-- Set button icon --}}
        @icon('filter', '', 'opacity-100')

        {{-- btn-dropdown --}}
        <div class="btn-dropdown-content">
            <div class="btn-dropdown-content-item rounded-lg border border-gray-300 shadow-md text-gray-600 text-left bg-white">
                {{-- Per page component --}}
                <belich::filters :filters="$filters" :text="trans('belich::default.filter')"></belich::filters>
            </div>
        </div>
    </div>

    {{-- Search state values --}}
    <input type="hidden" id="live_search_query" value="{{ $search['query'] ?? '' }}">
    <input type="hidden" id="live_search_page" value="{{ $search['page'] ?? '' }}">
    <input type="hidden" id="live_search_order" value="{{ $search['orderBy'] ?? '' }}">
    <input type="hidden" id="live_search_direction" value="{{ $search['direction'] ?? '' }}">
    <input type="hidden" id="live_search_filters" value="{{ $search['filters'] ?? '' }}">
@endif
