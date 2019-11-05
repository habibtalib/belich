<belich::fields :field="$field">
    <slot name="input">
        <textarea
            {!! Helper::setFormAttribute($field, 'addClass', 'mr-3') !!}
            {!! Helper::setFormAttribute($field, 'rows', 3) !!}
            {!! Helper::setFormAttribute($field, 'maxlength') !!}
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
