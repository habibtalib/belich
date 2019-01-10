@if(isset($field->formType) && $field->formType === 'grid')

@else
    @component('belich::fields.components.inlineForm')
        @slot('label', $field->name)
        @slot('field')
            <input
                id="{{ getFieldName($field) }}"
                name="{{ getFieldName($field) }}"
                dusk="{{ getFieldName($field) }}"
                type="text"
                value="{{ $field->value }}"
            >
            <p id="error-{{ getFieldName($field) }}" class="validation-error">&nbsp;</p>
        @endslot
    @endcomponent
@endif
