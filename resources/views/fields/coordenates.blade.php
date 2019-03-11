<belich::fields :field="$field">
    <slot name="input">
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
            <input type="hidden" name="cast[]" value="float|lat_{{ $field->attribute }}">

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
            <input type="hidden" name="cast[]" value="float|lng_{{ $field->attribute }}">
        </div>
    </slot>
</belich::fields>
