<belich::fields :field="$field">
    <slot name="input">
        <p class="{{ $field->color }}" onclick="toggleCheckbox('{{ $field->id }}');">
            <input
                type="checkbox"
                value="{{ $field->value ?? 0 }}"
                {!! setAttribute($field, 'addClass', 'itoggle ' . $field->color) !!}
                {!! $field->render !!}
                {!! setAttribute($field, 'checked') !!}
            >
            <label for="{{ $field->id }}"></label>
        </p>
    </slot>
</belich::fields>
