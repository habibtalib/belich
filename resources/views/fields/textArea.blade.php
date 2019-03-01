@if(isset($field->formType) && $field->formType === 'grid')

@else
    @component('belich::fields.components.inlineForm')
        @slot('label', $field->label)
        @slot('field')
            <textarea
                {!! setAttribute($field, 'addClass') !!}
                {!! setAttribute($field, 'rows', 4) !!}
                {!! setAttribute($field, 'maxlength') !!}
                {!! $field->count ? 'onkeydown="textAreaCount(this, \'' . $field->id . '\');"' : '' !!}
                {!! $field->render !!}
            >
                {{ $field->value }}
            </textarea>

            @if($field->help)
                <div class="help-text">{{ $field->help }}</div>
            @endif

            <p id="error-{{ $field->id }}" class="validation-error"></p>

           {{-- Show charts count --}}
            @isset($field->count)
                <p id="chars-{{ $field->id }}" class="italic mt-2"></p>
                @push('javascript')
                    @include('belich::dashboard.javascript.forms')
                @endpush
            @endisset
        @endslot
    @endcomponent
@endif
