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
        @endslot
    @endcomponent
@endif
