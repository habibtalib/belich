<belich::datalist :item="$field">
    {{-- Custom data --}}
    <slot name="data">
        @foreach(collect([]) as $value => $label)
            <option value="{{ $label }}" data-result="{{ $value }}">{{ $label }}</option>
        @endforeach
    </slot>
</belich::datalist>
