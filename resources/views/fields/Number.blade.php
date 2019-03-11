<belich::fields :field="$field">
    <slot name="input">
        <input
            {!! setAttribute($field, 'addClass') !!}
            {!! setAttribute($field, 'type') !!}
            {!! setAttribute($field, 'value') !!}
            {!! setAttribute($field, 'min') !!}
            {!! setAttribute($field, 'max') !!}
            {!! setAttribute($field, 'step') !!}
            {!! $field->render !!}
        >
    </slot>
</belich::fields>
