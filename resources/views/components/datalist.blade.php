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
            oninput="selectDatalist('{{ $item->attribute }}');"
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

@push('javascript')
    <script>
        {{-- Create the dataList --}}
        function selectDatalist(container) {
            if(document.getElementById('input-{{ $key }}')) {
                var val = document.getElementById('input-{{ $key }}').value;
                var opts = document.getElementById('list-{{ $key }}').childNodes;
                for(var i = 0; i < opts.length; i++) {
                    if(opts[i].value === val) {
                        // Update the value
                        document.getElementById(container).value = opts[i].getAttribute('data-result');
                        break;
                    }
                }
            }
        }
    </script>
@endpush

