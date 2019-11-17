<belich::fields :field="$field">
    <slot name="input">
        <input
            {!! Helper::formAttribute($field, 'addClass', 'mr-3') !!}
            {!! Helper::formAttribute($field, 'type') !!}
            {!! Helper::formAttribute($field, 'value') !!}
            {!! $field->render !!}
            list="datalist_{{ $field->id }}"
        >
        @isset($field->options)
            <datalist id="datalist_{{ $field->id }}">
                @foreach($field->options as $option)
                    <option>{{ $option }}</option>
                @endforeach
            </datalist>
        @endisset
    </slot>
</belich::fields>
