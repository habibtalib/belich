<belich::fields :label="$field->label">
    <slot name="field">
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

        @if($field->help)
            <div class="help-text">{{ $field->help }}</div>
        @endif

        <p id="error-{{ $field->id }}" class="validation-error"></p>
    </slot>
</belich::fields>
