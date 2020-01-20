{{-- Dropdown option --}}
<div class="w-full mb-1">
    {{-- Title --}}
    <div class="w-full p-4 bg-gray-500 rounded-t-lg text-white {{ $css ?? null }}">{{ $text ?? Helper::emptyResults() }}</div>

    {{-- Container --}}
    <div class="p-2 my-2 text-lg">
        {{-- Filters --}}
        @foreach($filters as $filter)
            {{-- Filter for date --}}
            @if($filter->filter === 'date')
                @include('belich::components.filters.filterDate')
            {{-- Regular filter --}}
            @else
                @include('belich::components.filters.filterSelect')
            @endif
        @endforeach
        {{-- Submit button --}}
        <div class="text-right">
            <button
                id="button-filter"
                dusk="dusk-button-filter"
                class="btn bg-blue-500 text-white mx-2 ml-4"
                onclick="javascript:liveFilter()"
            >
                {!! Helper::icon('filter', trans('belich::buttons.base.filter')) !!}
            </button>
        </div>
    </div>
</div>
