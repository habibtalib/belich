@if(isset($field->formType) && $field->formType === 'grid')

@else
    @component('belich::fields.components.inlineForm')
        @slot('label', $field->label)
        @slot('field')
            <textarea
                class="{{ $field->addClass }}"
                rows="{{ $field->rows ?? 4 }}"
                {!! $field->maxlength ? 'maxlength="' . $field->maxlength . '"' : '' !!}
                {!! $field->count ? 'onkeydown="textAreaCount(this, ' . $field->id . ');"' : '' !!}
                {!! $field->render !!}
            >
                {{ $field->value }}
            </textarea>

            @if($field->help)
                <div class="help-text">{{ $field->help }}</div>
            @endif

            <p id="error-{{ $field->id }}" class="validation-error"></p>
            @isset($field->count)
                <p id="chars-{{ $field->id }}" class="bg-green text-white"></p>
                @push('javascript')
                    @include('belich::dashboard.javascript.forms')
                @endpush
            @endisset
        @endslot
    @endcomponent
@endif
