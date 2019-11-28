<belich::fields :field="$field">
    <slot name="input">
        <input
            type="file"
            {!! Helper::formAttribute($field, 'addClass', 'mr-3') !!}
            {!! $field->render !!}
        >
        {{-- Hidden fields --}}
        <input type="hidden" name="__file[{{ $field->attribute }}][disk]" value="{{ $field->disk }}" dusk="disk-{{ $field->uriKey }}">
        @isset($field->storeName)
            <input type="hidden" name="__file[{{ $field->attribute }}][storeName]" value="{{ $field->storeName }}" dusk="storeName-{{ $field->uriKey }}">
        @endisset
        @isset($field->storeSize)
            <input type="hidden" name="__file[{{ $field->attribute }}][storeSize]" value="{{ $field->storeSize }}" dusk="storeSize-{{ $field->uriKey }}">
        @endisset
        @isset($field->storeMime)
            <input type="hidden" name="__file[{{ $field->attribute }}][storeMime]" value="{{ $field->storeMime }}" dusk="storeMime-{{ $field->uriKey }}">
        @endisset
    </slot>
</belich::fields>
