<belich::fields :label="$field->label">
    <slot name="field">
        <div class="flex w-full">
            {{-- Lat --}}
            <input
                type="number"
                {!! setAttribute($field, 'addClass') !!}
                {!! setAttribute($field, 'value') !!}
                {!! setAttribute($field, 'step') !!}
                {!! renderWithPrefix($field, 'lat') !!}
                placeholder="{{ trans('belich::units.lat') }}"
                decimals="6"
                class="float mr-3"
            >

            {{-- Lng --}}
            <input
                type="number"
                {!! setAttribute($field, 'addClass') !!}
                {!! setAttribute($field, 'value') !!}
                {!! setAttribute($field, 'step') !!}
                {!! renderWithPrefix($field, 'lng') !!}
                placeholder="{{ trans('belich::units.lng') }}"
                decimals="6"
                class="float ml-3"
            >
        </div>

        @if($field->help)
            <div class="help-text">{{ $field->help }}</div>
        @endif

        <p id="error-{{ $field->id }}" class="validation-error"></p>
    </slot>
</belich::fields>
