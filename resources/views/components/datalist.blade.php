<belich::fields :field="$field">
    <slot name="input">
        {{-- Set the autocomplete (visible) container --}}
        <input
            id="input-{{ md5($field->attribute) }}"
            list="list-{{ md5($field->attribute) }}"
            type="text"
            {!! setAttribute($field, 'addClass') !!}
            {!! setAttribute($field, 'disabled') !!}
            {!! setAttribute($field, 'readonly') !!}
            {!! setAttribute($field, 'value') !!}
            {!! $field->render !!}
            @if($field->responseArray)
                onchange="selectDatalist('{{ $field->attribute }}', '{{ md5($field->attribute) }}');"
            @elseif($field->responseUrl)
                onkeyup="requestAjax('{{ $field->responseUrl }}', '{{ md5($field->attribute) }}', '{{ $field->minChars }}', '{{ $field->addVars }}');"
                onchange="selectDatalist('{{ $field->attribute }}', '{{ md5($field->attribute) }}');"
            @endif
        >

        {{-- Hidden container with the value for storage --}}
        <input type="hidden" {!! $field->render !!} value="{{ $field->value }}">

        {{-- Create the data list --}}
        <datalist id="list-{{ md5($field->attribute) }}">
            @if($field->responseArray)
                @foreach($field->responseArray as $value => $text)
                    <option value="{{ $text }}" data-result="{{ $value }}">{{ $text }}</option>
                @endforeach
            @endif
        </datalist>

        {{-- Error container --}}
        <p id="error-{{ $field->id }}" class="validation-error"></p>

        {{-- Cast field --}}
        @include('belich::fields.cast')
    </slot>
</belich::fields>

@push('javascript')
    <script>
        {{-- Create the dataList --}}
        function selectDatalist(container, key) {
            if(document.getElementById('input-' + key)) {
                var val = document.getElementById('input-' + key).value;
                var opts = document.getElementById('list-' + key).childNodes;
                for(var i = 0; i < opts.length; i++) {
                    if(opts[i].value === val) {
                        // Update the value
                        document.getElementById(container).value = opts[i].getAttribute('data-result');
                        break;
                    }
                }
            }
        }

        function requestAjax(url, key, min, vars) {
            //Set default values
            const search = document.getElementById('input-' + key).value;
            const ajaxUrl = url + '/?search=' + search + (vars ? '&' + vars : '');
            var response;
            console.log(ajaxUrl);

            //Get ajax response
            if(search && search.length >= min) {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', ajaxUrl , true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.onreadystatechange = function() {
                    if(xhr.readyState == 4 && xhr.status == 200) {
                        var response = JSON.parse( xhr.responseText );
                        var container = document.getElementById('list-' + key);

                        // clear any previously loaded options in the datalist
                        container.innerHTML = "";

                        response.forEach(function(item) {
                            // Create a new <option> element.
                            var option = document.createElement('option');
                            option.value = item.label;
                            option.setAttribute('data-result', option.value);

                            // attach the option to the datalist element
                            container.appendChild(option);
                        });
                    }
                };
                xhr.send();
            }
        }
    </script>
@endpush
