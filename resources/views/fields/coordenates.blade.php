<belich::fields :field="$field">
    <slot name="input">
        <div class="flex w-full">
            {{-- Lat --}}
            <input
                type="number"
                {!! Helper::setFormAttribute($field, 'addClass') !!}
                {!! Helper::setFormAttribute($field, 'value') !!}
                {!! Helper::setFormAttribute($field, 'step') !!}
                {!! Helper::renderWithPrefix($field, 'lat') !!}
                placeholder="{{ trans('belich::units.lat') }}"
                onkeyup="javascript:onlyNumerics(this)"
                onblur="javascript:setDecimals(this, 6)"
                class="mr-3"
            >
            <input type="hidden" name="cast[]" value="float|lat_{{ $field->attribute }}">

            {{-- Lng --}}
            <input
                type="number"
                {!! Helper::setFormAttribute($field, 'addClass') !!}
                {!! Helper::setFormAttribute($field, 'value') !!}
                {!! Helper::setFormAttribute($field, 'step') !!}
                {!! Helper::renderWithPrefix($field, 'lng') !!}
                placeholder="{{ trans('belich::units.lng') }}"
                onkeyup="javascript:onlyNumerics(this)"
                onblur="javascript:setDecimals(this, 6)"
                class="ml-3"
            >
            <input type="hidden" name="cast[]" value="float|lng_{{ $field->attribute }}">
        </div>
    </slot>
</belich::fields>
