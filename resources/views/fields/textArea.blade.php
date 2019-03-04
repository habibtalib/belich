

<belich::fields :label="$field->label">
    <slot name="field">
         <textarea
             {!! setAttribute($field, 'addClass') !!}
             {!! setAttribute($field, 'rows', 3) !!}
             {!! setAttribute($field, 'maxlength') !!}
             {!! $field->count ? 'onkeyup="textAreaCount(this, \'' . $field->id . '\');"' : '' !!}
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

         @include('belich::fields.cast')
    </slot>
</belich::fields>
