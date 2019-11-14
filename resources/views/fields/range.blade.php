<belich::fields :field="$field">
    <slot name="input">
        <input
            {!! Helper::setFormAttribute($field, 'addClass', 'mr-3') !!}
            {!! Helper::setFormAttribute($field, 'type') !!}
            {!! Helper::setFormAttribute($field, 'value') !!}
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
