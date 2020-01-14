{{-- Dropdown option --}}
<div class="w-full mb-1">
    {{-- Title --}}
    <div class="w-full p-4 bg-gray-500 rounded-t-lg text-white {{ $css ?? null }}">{{ $text ?? Helper::emptyResults() }}</div>

    {{-- Container --}}
    <div class="p-2 my-2 text-lg">
        {{-- Filters --}}
        @foreach($filters as $filter)
            <div class="pb-6">
                <label>{{ $filter->label }}</label>
                <select id="{{ $filter->id }}" data-filter="{{ $filter->filter ?? 'equal' }}" class="search-live-filter w-full h-10 border border-gray-400">
                    <option></option>
                    @foreach($filter->options as $value => $option)
                        <option data-row="{{ $option }}" data-value="{{ $value }}">{{ $option }}</option>
                    @endforeach
                </select>
            </div>
        @endforeach

        {{-- Submit buttons --}}
        <div class="w-full flex flex-row-reverse p-2 mb-2">
            <button id="filterSearch" type="submit" class="btn bg-blue-500 text-white" dusk="table-options-submit" onclick="window.liveFilter();">
                {!! Helper::icon('search-plus', trans('belich::buttons.base.filter')) !!}
            </button>
        </div>
    </div>
</div>

{{-- @push('javascript')
    <script>
        document.getElementById('filterSearch').addEventListener('click', function() {
            window.liveFilter();
        });
    </script>
@endpush --}}
