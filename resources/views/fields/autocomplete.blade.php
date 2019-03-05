<belich::fields :label="$field->label">
    <slot name="field">
        {{-- Set the visible container --}}
        <input
            id="autocompleteInput"
            list="autocompleteList"
            type="text"
            value="{{ $field->response[$field->value] ?? null }}"
            oninput="selectDatalist('{{ $field->attribute }}');"
        >

        {{-- Hidden container with the value for storage --}}
        <input type="hidden" {!! $field->render !!} value="{{ $field->value }}">

        {{-- Create the data list --}}
        <datalist id="autocompleteList">
            @foreach($field->response as $value => $label)
                <option value="{{ $label }}" data-result="{{ $value }}">{{ $label }}</option>
            @endforeach
          </datalist>

        {{-- Help container --}}
        @if($field->help)
            <div class="help-text">{{ $field->help }}</div>
        @endif

        {{-- Error container --}}
        <p id="error-{{ $field->id }}" class="validation-error"></p>

        {{-- Cast field --}}
        @include('belich::fields.cast')
    </slot>
</belich::fields>

@push('javascript')
    <script>
        {{-- Create the dataList --}}
        function selectDatalist(container) {
            if(document.getElementById('autocompleteInput')) {
                var val = document.getElementById('autocompleteInput').value;
                var opts = document.getElementById('autocompleteList').childNodes;
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
