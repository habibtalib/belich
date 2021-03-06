<belich::fields :field="$field">
    <slot name="input">
        <textarea
            {!! Helper::formAttribute($field, 'addClass', 'mr-3') !!}
            {!! Helper::formAttribute($field, 'rows', $field->rows ?? 3) !!}
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
