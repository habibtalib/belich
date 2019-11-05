<belich::fields :field="$field">
    <slot name="input">
        <input
            type="file"
            {!! Helper::setFormAttribute($field, 'addClass', 'mr-3') !!}
            {!! $field->render !!}
        >
        <input type="hidden" name="__file[{{ $field->attribute }}][disk]" value="{{ $field->disk }}">
        <input type="hidden" name="__file[{{ $field->attribute }}][originalName]" value="{{ $field->storeOriginalName }}">
    </slot>
</belich::fields>
