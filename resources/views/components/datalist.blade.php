@php
    $key = md5($item->attribute);
@endphp

<belich::fields :label="$item->label">
    <slot name="field">
        {{-- Set the visible container --}}
        <input
            id="input-{{ $key }}"
            list="list-{{ $key }}"
            type="text"
            value="{{ $value ?? null }}"
            onchange="selectDatalist('{{ $item->attribute }}', '{{ $key }}');"
        >

        {{-- Hidden container with the value for storage --}}
        <input type="hidden" {!! $item->render !!} value="{{ $item->value }}">

        {{-- Create the data list --}}
        <datalist id="list-{{ $key }}">
            {{ $data }}
        </datalist>

        {{-- Help container --}}
        @if($item->help)
            <div class="help-text">{{ $item->help }}</div>
        @endif

        {{-- Error container --}}
        <p id="error-{{ $item->id }}" class="validation-error"></p>

        {{-- Cast field --}}
        @include('belich::fields.cast')
    </slot>
</belich::fields>

