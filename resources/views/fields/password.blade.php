<belich::fields :field="$field">
    <slot name="input">
        <input
            {!! Helper::formAttribute($field, 'addClass', 'mr-3') !!}
            {!! Helper::formAttribute($field, 'type') !!}
            {!! $field->render !!}
        >
    </slot>
</belich::fields>
