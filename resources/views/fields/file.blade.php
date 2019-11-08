<belich::fields :field="$field">
    <slot name="input">
        <input
            type="file"
            {!! Helper::setFormAttribute($field, 'addClass', 'mr-3') !!}
            {!! $field->render !!}
        >
        {{-- Hidden fields --}}
        <input type="hidden" name="__file[{{ $field->attribute }}][disk]" value="{{ $field->disk }}" dusk="disk-{{ md5($field->id) }}">
        @isset($field->storeName)
            <input type="hidden" name="__file[{{ $field->attribute }}][storeName]" value="{{ $field->storeName }}" dusk="storeName-{{ md5($field->id) }}">
        @endisset
        @isset($field->storeSize)
            <input type="hidden" name="__file[{{ $field->attribute }}][storeSize]" value="{{ $field->storeSize }}" dusk="storeSize-{{ md5($field->id) }}">
        @endisset
        @isset($field->storeMime)
            <input type="hidden" name="__file[{{ $field->attribute }}][storeMime]" value="{{ $field->storeMime }}" dusk="storeMime-{{ md5($field->id) }}">
        @endisset
    </slot>
</belich::fields>
