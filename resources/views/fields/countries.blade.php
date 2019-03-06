<belich::datalist
    :item="$field"
    :value="$field->response[$field->value]"
>

    {{-- Custom data --}}
    <slot name="data">
        @foreach($field->response as $value => $label)
            <option value="{{ $label }}" data-result="{{ $value }}">{{ $label }}</option>
        @endforeach
    </slot>
</belich::datalist>
