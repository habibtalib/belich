<belich::fields :field="$field">
    <slot name="input">
        <input
            {!! setAttribute($field, 'addClass') !!}
            {!! setAttribute($field, 'type') !!}
            {!! $field->render !!}
        >
    </slot>
</belich::fields>
