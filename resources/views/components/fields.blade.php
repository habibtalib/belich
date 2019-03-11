<div class="form-group">
    <div class="form-inline-label">
        <label>{{ $field->label ?? null }}</label>
    </div>
    <div class="form-inline-field">
        {{-- Displaying the field --}}
        {{ $input ?? null }}

        @isset($field->help)
            <div class="help-text">{{ $field->help }}</div>
        @endisset

        @isset($field->id)
            <p id="error-{{ $field->id }}" class="validation-error"></p>
        @endif

        @include('belich::fields.cast')
    </div>
</div>
