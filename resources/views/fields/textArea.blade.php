<belich::fields :field="$field">
    <slot name="input">
        <textarea
            {!! setAttribute($field, 'addClass') !!}
            {!! setAttribute($field, 'rows', 3) !!}
            {!! setAttribute($field, 'maxlength') !!}
            {!! $field->count ? 'onkeyup="textAreaCount(this, \'' . $field->id . '\');"' : '' !!}
            {!! $field->render !!}
        >
            {{ $field->value }}
         </textarea>

        {{-- Show charts count --}}
         @isset($field->count)
            <p id="chars-{{ $field->id }}" class="italic mt-2"></p>
        @endisset
    </slot>
</belich::fields>
