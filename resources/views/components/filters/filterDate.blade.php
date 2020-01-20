{{-- Filter for date --}}
<div class="pb-6">
    <label>{{ $filter->label }}</label>
    <div class="flex w-full search-live-filter-date" data-format="{{ $filter->format }}" data-table="{{ $filter->id }}">
        <input type="text" id="{{ $filter->id }}-start" dusk="dusk-filter-{{ $filter->id }}-start" class="flex-1 w-1/2 mr-2 p-2 h-10 bg-gray-100 border border-gray-400" data-mask="{{ $filter->mask }}" placeholder="Start date" onkeyup="javascript:maskHandler(this);">
        <input type="text" id="{{ $filter->id }}-end" dusk="dusk-filter-{{ $filter->id }}-end" class="flex-1 w-1/2  p-2 h-10 bg-gray-100 border border-gray-400" data-mask="{{ $filter->mask }}" placeholder="End date" onkeyup="javascript:maskHandler(this);">
    </div>
</div>

@push('javascript')
    <script>
        //Set default values
        document.addEventListener("DOMContentLoaded", function() {
            window.maskHandler(document.getElementById('{{ $filter->id }}-start'));
            window.maskHandler(document.getElementById('{{ $filter->id }}-end'));
        })
    </script>
@endpush

@include('belich::fields.pattern-js')
