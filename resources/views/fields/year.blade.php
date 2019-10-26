<belich::fields :field="$field">
    <slot name="input">
        <input
            {!! setAttribute($field, 'addClass') !!}
            {!! setAttribute($field, 'type') !!}
            {!! setAttribute($field, 'value') !!}
            {!! $field->render !!}
            maxlength="4"
            onkeyup="javascript:onlyNumerics(this)"
        >
    </slot>
</belich::fields>
