{{-- Filter for date --}}
<div class="pb-6">
    <label>{{ $filter->label }}</label>
    <div class="flex w-full">
        <input id="{{ $filter->id }}-start" data-date="start" type="text" data-mask="{{ $filter->mask }}" class="search-live-filter-date flex-1 w-1/2 mr-2 p-2 h-10 bg-gray-100 border border-gray-400" placeholder="Start date" onkeyup="javascript:maskHandler(this);">
        <input id="{{ $filter->id }}-end" data-date="end" type="text" data-mask="{{ $filter->mask }}" class="search-live-filter-date flex-1 w-1/2  p-2 h-10 bg-gray-100 border border-gray-400" placeholder="End date" onkeyup="javascript:maskHandler(this);">
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
