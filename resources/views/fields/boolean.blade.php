<belich::fields :label="$field->label">
    <slot name="field">
        <p class="normal">
            <input
                type="checkbox"
                id="normal-toggle"
                {!! setAttribute($field, 'addClass', 'itoggle') !!}
                {!! $field->render !!}
            >
            <label for="normal-toggle"></label>
        </p>

        @if($field->help)
            <div class="help-text">{{ $field->help }}</div>
        @endif

        <p id="error-{{ $field->id }}" class="validation-error"></p>
    </slot>
</belich::fields>
