<belich::fields :field="$field">
    <slot name="input">
        <input
            type="file"
            {!! setAttribute($field, 'addClass') !!}
            {!! setAttribute($field, 'value') !!}
            {!! $field->render !!}
            {{-- accept="image/*,.pdf" --}}
        >
        <input type="hidden" name="__file[{{ $field->attribute }}][disk]" value="{{ $field->disk }}">
        <input type="hidden" name="__file[{{ $field->attribute }}][originalName]" value="{{ $field->storeOriginalName }}">
    </slot>
</belich::fields>