<belich::fields :field="$field">
    <slot name="input">
        <div class="flex w-full">
            <input
                type="number"
                {!! Helper::formAttribute($field, 'addClass', 'mr-3') !!}
                {!! Helper::formAttribute($field, 'value') !!}
                {!! Helper::formAttribute($field, 'step') !!}
                {!! $field->render !!}
                onkeyup="javascript:onlyNumerics(this)"
                @if($field->toDegrees ?? false)
                    onblur="javascript:updateCoordenates(this, '{{ $field->key }}', '{{ $field->coordenateType }}');"
                @else
                    onblur="javascript:setDecimals(this, {{ $field->decimals ?? 2 }})"
                @endif
            >
        </div>
    </slot>
</belich::fields>

{{-- Convert coordenates Latlng to Degrees --}}
@includeWhen($field->toDegrees ?? false, 'belich::fields.coordenates')
