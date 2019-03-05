<belich::datalist
    :item="$field"
    :value="$field->countries[$field->value]"
    jsFunction="selectDatalist"
>


    {{-- Custom data --}}
    <slot name="data">
        @foreach($field->countries as $value => $label)
            <option value="{{ $label }}" data-result="{{ $value }}">{{ $label }}</option>
        @endforeach
    </slot>
</belich::datalist>
