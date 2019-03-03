<belich::fields :label="$field->label">
    <slot name="field">
        <div class="flex w-full">
            {{-- Lat --}}
            <input
            placeholder="{{ trans('belich::units.lat') }}"
            class="mr-3"
            {!! setAttribute($field, 'addClass') !!}
            {!! setAttribute($field, 'value') !!}
            {!! setAttribute($field, 'step') !!}
            {!! renderWithPrefix($field, 'lat') !!}
            >

            {{-- Lng --}}
            <input
                placeholder="{{ trans('belich::units.lng') }}"
                class="ml-3"
                {!! setAttribute($field, 'addClass') !!}
                {!! setAttribute($field, 'value') !!}
                {!! setAttribute($field, 'step') !!}
                {!! renderWithPrefix($field, 'lng') !!}
            >
        </div>

        @if($field->help)
            <div class="help-text">{{ $field->help }}</div>
        @endif

        <p id="error-{{ $field->id }}" class="validation-error"></p>
    </slot>
</belich::fields>
