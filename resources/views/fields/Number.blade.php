<belich::fields :field="$field">
    <slot name="input">
        <input
            {!! Helper::setFormAttribute($field, 'addClass', 'mr-3') !!}
            {!! Helper::setFormAttribute($field, 'type') !!}
            {!! Helper::setFormAttribute($field, 'value') !!}
            {!! Helper::setFormAttribute($field, 'min') !!}
            {!! Helper::setFormAttribute($field, 'max') !!}
            {!! Helper::setFormAttribute($field, 'step') !!}
            {!! $field->render !!}
            onkeyup="javascript:onlyNumerics(this)"
        >
    </slot>
</belich::fields>
