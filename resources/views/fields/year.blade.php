<belich::fields :field="$field">
    <slot name="input">
        <input
            {!! Helper::setFormAttribute($field, 'addClass') !!}
            {!! Helper::setFormAttribute($field, 'type') !!}
            {!! Helper::setFormAttribute($field, 'value') !!}
            {!! $field->render !!}
            maxlength="4"
            onkeyup="javascript:onlyNumerics(this)"
        >
    </slot>
</belich::fields>
