<belich::fields :field="$field">
    <slot name="input">
        <input
            {!! Helper::setFormAttribute($field, 'addClass') !!}
            {!! Helper::setFormAttribute($field, 'type') !!}
            {!! Helper::setFormAttribute($field, 'value') !!}
            {!! $field->render !!}
        >
    </slot>
</belich::fields>
