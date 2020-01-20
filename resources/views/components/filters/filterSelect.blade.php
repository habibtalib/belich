<div class="pb-6">
    <label>{{ $filter->label }}</label>
    <select id="{{ $filter->id }}" dusk="dusk-filter-{{ $filter->id }}" data-filter="{{ $filter->filter ?? 'equal' }}" class="search-live-filter w-full h-10 border border-gray-400">
        <option></option>
        @foreach($filter->options as $value => $option)
            <option data-row="{{ $option }}" value="{{ $value }}">{{ $option }}</option>
        @endforeach
    </select>
</div>
