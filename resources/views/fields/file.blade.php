<belich::fields :field="$field">
    <slot name="input">
        <input
            type="file"
            {!! setAttribute($field, 'addClass') !!}
            {!! setAttribute($field, 'value') !!}
            {!! $field->render !!}
            {{-- accept="image/*,.pdf" --}}
        >
        <input type="hidden" name="__file[{{ $field->attribute }}][disk]" value="{{ $field->disk ?? 'public' }}">
        <input type="hidden" name="__file[{{ $field->attribute }}][prunable]" value="{{ $field->prunable ?? 0 }}">
        <input type="hidden" name="__file[{{ $field->attribute }}][originalName]" value="{{ $field->storeOriginalName ?? 0 }}">
    </slot>
</belich::fields>
