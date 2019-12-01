<belich::fields :field="$field">
    <slot name="input">
        <textarea
            {!! Helper::formAttribute($field, 'addClass', 'mr-3') !!}
            {!! Helper::formAttribute($field, 'rows', $field->rows ?? 3) !!}
            {!! Helper::formAttribute($field, 'maxlength') !!}
            {!! $field->render !!}
        >
            {!! $field->value !!}
         </textarea>
    </slot>
</belich::fields>
