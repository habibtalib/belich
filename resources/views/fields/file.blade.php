<belich::fields :label="$field->label">
    <slot name="field">
        <input
            type="file"
            enctype="multipart/form-data"
            {!! setAttribute($field, 'addClass') !!}
            {!! setAttribute($field, 'value') !!}
            {!! $field->render !!}
            {{-- accept="image/*,.pdf" --}}
        >

        @if($field->help)
            <div class="help-text">{{ $field->help }}</div>
        @endif

        <p id="error-{{ $field->id }}" class="validation-error"></p>

        @include('belich::fields.cast')
    </slot>
</belich::fields>
