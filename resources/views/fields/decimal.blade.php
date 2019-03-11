<belich::fields :field="$field">
    <slot name="input">
        <div class="flex w-full">
            {{-- Lat --}}
            <input
                type="number"
                {!! setAttribute($field, 'addClass') !!}
                {!! setAttribute($field, 'value') !!}
                {!! setAttribute($field, 'step') !!}
                {!! setAttribute($field, 'decimals', 2) !!}
                {!! $field->render !!}
                class="float mr-3"
            >
    </slot>
</belich::fields>
