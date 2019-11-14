<belich::fields :field="$field">
    <slot name="input">
        <input
            {!! Helper::setFormAttribute($field, 'addClass', 'mr-3') !!}
            {!! Helper::setFormAttribute($field, 'type') !!}
            {!! Helper::setFormAttribute($field, 'value') !!}
            {!! $field->render !!}
            onkeyup="javascript:onlyNumerics(this)"
        >
    </slot>
</belich::fields>
