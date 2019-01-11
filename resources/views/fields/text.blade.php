@if(isset($field->formType) && $field->formType === 'grid')

@else
    @component('belich::fields.components.inlineForm')
        @slot('label', $field->name)
        @slot('field')
            <input
                id="{{ setFieldName($field) }}"
                name="{{ setFieldName($field) }}"
                dusk="{{ setFieldName($field) }}"
                type="text"
                value="{{ $field->value }}"
            >
            <p id="error-{{ setFieldName($field) }}" class="validation-error"></p>
        @endslot
    @endcomponent
@endif
