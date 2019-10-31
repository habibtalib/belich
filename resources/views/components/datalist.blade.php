<belich::fields :field="$field">
    <slot name="input">
        {{-- Set the autocomplete (visible) container --}}
        <input
            id="input_{{ md5($field->attribute) }}"
            list="list_{{ md5($field->attribute) }}"
            type="text"
            dusk="dusk-autocomplete-{{ $field->attribute }}"
            {!! setAttribute($field, 'addClass') !!}
            {!! setAttribute($field, 'value') !!}
            {!! $field->render !!}
            @if($field->responseArray)
                onchange="javascript:selectDatalist('{{ $field->attribute }}', '{{ md5($field->attribute) }}');"
            @elseif($field->responseUrl)
                onkeyup="javascript:requestAjax('{{ $field->responseUrl }}', '{{ md5($field->attribute) }}', '{{ $field->minChars }}', '{{ $field->addVars }}');"
            @endif
        >

        {{-- Hidden container with the value for storage --}}
        <input type="hidden" {!! $field->render !!} value="{{ $field->value }}">

        {{-- Create the data list --}}
        @if($field->responseArray)
            <datalist id="list_{{ md5($field->attribute) }}">
                    @foreach($field->responseArray as $value => $text)
                        <option value="{{ $text }}" data-result="{{ $value }}">{{ $text }}</option>
                    @endforeach
            </datalist>
        @else
            <div class="relative">
                <ul id="list_{{ md5($field->attribute) }}" class="absolute left-0 top-0 bg-white border border-t-0 border-gray-400 hidden mb-4"></ul>
            </div>
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
        function selectDatalist(container, key) {
            if(document.getElementById('input_' + key)) {
                var val = document.getElementById('input_' + key).value;
                var opts = document.getElementById('list_' + key).childNodes;
                for(var i = 0; i < opts.length; i++) {
                    if(opts[i].value === val) {
                        // Update the value
                        document.getElementById(container).value = opts[i].getAttribute('data-result');
                        break;
                    }
                }
            }
        }

        function clickDatalist(key, value) {
            //Hide the container
            var container = document.getElementById('list_' + key);
            container.classList.remove('hidden', 'block');
            container.classList.add('hidden');
            //Add value to input
            document.getElementById('input_' + key).value = value;
            document.getElementById('{!! $field->attribute !!}').value = value;
        }

        function requestAjax(url, key, min, vars) {
            //Set default values
            let response;
            let search = document.getElementById('input_' + key).value;
            let ajaxUrl = url + '/?search=' + search + (vars ? '&' + vars : '');
            var container = document.getElementById('list_' + key);

            //Get ajax response
            if(search && search.length >= min) {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', ajaxUrl , true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.onload = function() {
                    if(xhr.readyState == 4 && xhr.status == 200) {
                        //Make visible the container
                        container.classList.remove('hidden', 'block');
                        container.classList.add('block');
                        response = JSON.parse( xhr.responseText );
                        // clear any previously loaded options in the datalist
                        container.innerHTML = "";
                        // Populate...
                        response.forEach(function(item) {
                            // Create a new <li> element.
                            var selector = document.createElement('li');
                            selector.setAttribute('class', 'py-4 px-5 border-b border-gray-300');
                            var link = document.createElement('a');
                            link.setAttribute('href', 'javascript:void(0)');
                            link.setAttribute('class', 'datalist');
                            link.setAttribute('onclick', 'javascript:clickDatalist("' + key + '", "' + item.label + '")');
                            link.innerHTML = item.label;
                            // attach the selector to the datalist element
                            container.appendChild(selector);
                            selector.appendChild(link);
                        });
                    }
                };
                xhr.send();
            }
        }
    </script>
@endpush
