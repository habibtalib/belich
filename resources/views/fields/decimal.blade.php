<belich::fields :field="$field">
    <slot name="input">
        <div class="flex w-full">
            <input
                type="number"
                {!! setAttribute($field, 'addClass') !!}
                {!! setAttribute($field, 'value') !!}
                {!! setAttribute($field, 'step') !!}
                {!! $field->render !!}
                class="mr-3"
                onkeyup="javascript:onlyNumerics(this)"
                onblur="javascript:setDecimals(this, {{ $field->decimals ?? 2 }})"
            >
        </div>
    </slot>
</belich::fields>
