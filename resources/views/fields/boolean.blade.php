<belich::fields :label="$field->label">
    <slot name="field">
        <p class="{{ $field->color }}">
            <input
                type="checkbox"
                {!! setAttribute($field, 'addClass', 'itoggle ' . $field->color) !!}
                {!! $field->render !!}
            >
            <label for="{{ $field->id }}"></label>
        </p>

        @if($field->help)
            <div class="help-text">{{ $field->help }}</div>
        @endif

        <p id="error-{{ $field->id }}" class="validation-error"></p>
    </slot>
</belich::fields>
