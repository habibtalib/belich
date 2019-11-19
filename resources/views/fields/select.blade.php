<belich::fields :field="$field">
    <slot name="input">
        <div class="inline-block relative w-full">
            <select
                {!! Helper::formAttribute($field, 'addClass', 'block px-4 py-2 pr-8') !!}
                {!! $field->render !!}
            >
                @isset($field->options)
                    @foreach($field->options as $value => $text)
                        <option
                            value="{{ $value }}"
                            {{ $field->value == $value ? 'selected="selected"' : '' }}
                        >
                            {{ $text }}
                        </option>
                    @endforeach
                @endisset
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                </svg>
            </div>
        </div>
    </slot>
</belich::fields>
