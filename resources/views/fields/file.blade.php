<belich::fields :field="$field">
    <slot name="input">
        <input
            type="file"
            enctype="multipart/form-data"
            {!! setAttribute($field, 'addClass') !!}
            {!! setAttribute($field, 'value') !!}
            {!! $field->render !!}
            {{-- accept="image/*,.pdf" --}}
        >
    </slot>
</belich::fields>
