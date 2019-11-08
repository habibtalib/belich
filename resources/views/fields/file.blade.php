<belich::fields :field="$field">
    <slot name="input">
        <input
            type="file"
            {!! Helper::setFormAttribute($field, 'addClass', 'mr-3') !!}
            {!! $field->render !!}
        >
        {{-- Hidden fields --}}
        <input type="hidden" name="__file[{{ $field->attribute }}][disk]" value="{{ $field->disk }}">
        @isset($field->storeName)
            <input type="hidden" name="__file[{{ $field->attribute }}][storeName]" value="{{ $field->storeName }}">
        @endisset
        @isset($field->storeSize)
            <input type="hidden" name="__file[{{ $field->attribute }}][storeSize]" value="{{ $field->storeSize }}">
        @endisset
        @isset($field->storeMime)
            <input type="hidden" name="__file[{{ $field->attribute }}][storeMime]" value="{{ $field->storeMime }}">
        @endisset
    </slot>
</belich::fields>
