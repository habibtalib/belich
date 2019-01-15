@if(isset($field->formType) && $field->formType === 'grid')

@else
    @component('belich::fields.components.inlineForm')
        @slot('label', $field->label)
        @slot('field')
            <input
                id="{{ $field->id }}"
                name="{{ $field->name }}"
                dusk="{{ $field->dusk }}"
                type="text"
                value="{{ $field->value }}"
            >
            <p id="error-{{ $field->attribute }}" class="validation-error"></p>
        @endslot
    @endcomponent
@endif
