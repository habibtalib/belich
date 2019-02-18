{{-- Dropdown option --}}
<div class="w-full mb-1">
    <div class="w-full p-4 bg-grey-lighter border-b border-grey-light">{!! icon($icon, $text, 'opacity-50') !!}</div>
    <div class="p-2 text-lg">
        <select name="{{ $field }}" class="w-full h-10">
            <option></option>
            @foreach($options as $option)
                @php
                    if(is_array($option)) {
                        $value = array_keys($option)[0];
                        $label = array_values($option)[0];
                    } else {
                        $value = $label = $option;
                    }
                @endphp
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </select>
    </div>
</div>
