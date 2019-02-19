{{-- Dropdown option --}}
<div class="w-full mb-1">
    <div class="w-full p-4 bg-grey-lighter border-b border-grey-lighter {{ $css ?? null }}">{{ $text ?? emptyResults() }}</div>
    <div class="p-2 my-2 text-lg">
        @isset($options)
            <select name="{{ $field }}" class="w-full h-10 border border-grey-light">
                @foreach($options as $option)
                    @optionFromArray($field, $option)
                @endforeach
            </select>
        @else
            {{ $custom ?? emptyResults() }}
        @endisset
    </div>
</div>
