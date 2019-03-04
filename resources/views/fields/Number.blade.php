<belich::fields :label="$field->label">
    <slot name="field">
        <input
            {!! setAttribute($field, 'addClass') !!}
            {!! setAttribute($field, 'type') !!}
            {!! setAttribute($field, 'value') !!}
            {!! setAttribute($field, 'min') !!}
            {!! setAttribute($field, 'max') !!}
            {!! setAttribute($field, 'step') !!}
            {!! $field->render !!}
        >

        @if($field->help)
            <div class="help-text">{{ $field->help }}</div>
        @endif

        <p id="error-{{ $field->id }}" class="validation-error"></p>

        @include('belich::fields.cast')
    </slot>
</belich::fields>
