<belich::fields :field="$field">
    <slot name="input">
        <input
            {!! Helper::setFormAttribute($field, 'addClass', 'mr-3') !!}
            {!! Helper::setFormAttribute($field, 'type') !!}
            {!! Helper::setFormAttribute($field, 'value') !!}
            {!! $field->render !!}
        >
    </slot>
</belich::fields>
