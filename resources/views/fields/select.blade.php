@if(isset($field->formType) && $field->formType === 'grid')

@else
    @component('belich::fields.components.inlineForm')
        @slot('label', $field->label)
        @slot('field')
            <div class="select-container">
                <select
                    {!! setAttribute($field, 'addClass') !!}
                    {!! $field->render !!}
                >
                    @foreach($field->options as $value => $text)
                        <option value="{{ $value }}" {{ $field->value === $value ? 'selected="selected"' : '' }}>{{ $text }}</option>
                    @endforeach
                </select>
                <div class="icon">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                    </svg>
                </div>
            </div>

            @if($field->help)
                <div class="help-text">{{ $field->help }}</div>
            @endif

            <p id="error-{{ $field->id }}" class="validation-error"></p>
        @endslot
    @endcomponent
@endif
