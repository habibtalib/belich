<belich::fields :label="$field->label">
    <slot name="field">
        <input
            {!! setAttribute($field, 'addClass') !!}
            {!! setAttribute($field, 'type') !!}
            {!! setAttribute($field, 'value') !!}
            {!! $field->render !!}
        >

        @if($field->help)
            <div class="help-text">{{ $field->help }}</div>
        @endif

        <p id="error-{{ $field->id }}" class="validation-error"></p>
    </slot>
</belich::fields>
