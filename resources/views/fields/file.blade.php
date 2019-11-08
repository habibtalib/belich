<belich::fields :field="$field">
    <slot name="input">
        <input
            type="file"
            {!! Helper::setFormAttribute($field, 'addClass', 'mr-3') !!}
            {!! $field->render !!}
        >
        {{-- Hidden fields --}}
        <input type="hidden" name="__file[{{ $field->attribute }}][disk]" value="{{ $field->disk }}">
        @isset($field->storeNameValue)
            <input type="hidden" name="__file[{{ $field->attribute }}][storeName]" value="{{ $field->storeNameValue}}">
        @endisset
        @isset($field->storeSizeValue)
            <input type="hidden" name="__file[{{ $field->attribute }}][storeSize]" value="{{ $field->storeSizeValue }}">
        @endisset
        @isset($field->storeMimeValue)
            <input type="hidden" name="__file[{{ $field->attribute }}][storeMime]" value="{{ $field->storeMimeValue }}">
        @endisset
    </slot>
</belich::fields>
