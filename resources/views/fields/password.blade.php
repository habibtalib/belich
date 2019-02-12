@if(isset($field->formType) && $field->formType === 'grid')

@else
    @component('belich::fields.components.inlineForm')
        @slot('label', $field->label)
        @slot('field')
            <input class="{{ $field->addClass }}" type="{{ $field->type }}" {{ $field->render }}>

            @if($field->help)
                <div class="help-text">{{ $field->help }}</div>
            @endif

            <p id="error-{{ $field->id }}" class="validation-error"></p>
        @endslot
    @endcomponent
@endif
