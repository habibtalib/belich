<belich::fields :field="$field">
    <slot name="input">
        <p class="{{ $field->color }}" onclick="toggleCheckbox('{{ $field->id }}');">
            <input
                type="checkbox"
                value="{{ $field->value ?? 0 }}"
                {!! Helper::formAttribute($field, 'addClass', 'itoggle ' . $field->color) !!}
                {!! $field->render !!}
                {!! Helper::formAttribute($field, 'checked') !!}
            >
            <label for="{{ $field->id }}" dusk="label-{{ $field->id }}"></label>
        </p>
    </slot>
</belich::fields>
