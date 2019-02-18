{{-- Dropdown option --}}
<div class="w-full mb-1">
    <div class="w-full p-4 bg-grey-lighter border-b border-grey-light">{!! icon($icon, $text, 'opacity-50') !!}</div>
    <div class="p-2 text-lg">
        @isset($options)
            <select name="{{ $field }}" class="w-full h-10">
                <option></option>
                @foreach($options as $option)
                    @if(is_array($option) && count($option) <= 1)
                        <option value="{{ array_keys($option)[0] }}">{{ array_values($option)[0] }}</option>
                    @else
                        @isset($option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endisset
                    @endif
                @endforeach
            </select>
        @else
            hellow
        @endisset
    </div>
</div>
