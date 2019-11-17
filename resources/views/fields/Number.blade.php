<belich::fields :field="$field">
    <slot name="input">
        <input
            {!! Helper::formAttribute($field, 'addClass', 'mr-3') !!}
            {!! Helper::formAttribute($field, 'type') !!}
            {!! Helper::formAttribute($field, 'value') !!}
            {!! $field->render !!}
            onkeyup="javascript:onlyNumerics(this)"
        >
    </slot>
</belich::fields>
