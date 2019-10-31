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
                onchange="javascript:createDatalistFromArray('{{ $field->attribute }}', '{{ md5($field->attribute) }}');"
            @elseif($field->responseUrl)
                onkeyup="javascript:requestDatalistFromAjax('{{ $field->responseUrl }}', '{{ md5($field->attribute) }}', '{{ $field->minChars }}', '{{ $field->addVars }}');"
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
        // Create a dataList from array
        function createDatalistFromArray(container, key) {
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

        // Select value from datalist
        function selectFromDatalist(key, final, value) {
            //Get the container
            var container = document.getElementById('list_' + key);
            //Hide the container
            window.toogleContainer(container, 'hidden');
            //Add value to input
            document.getElementById('input_' + key).value = value;
            document.getElementById('{!! $field->attribute !!}').value = final;
        }

        //Create the datalist container
        function createDatalistContainer(container, key, id, value) {
            // Create a new <li> element
            var selector = document.createElement('li');
            selector.setAttribute('class', 'py-4 px-5 border-b border-gray-300');
            // Create a new <a> element
            var link = document.createElement('a');
            // Set value
            var store = '{{ $field->store }}';
            var final = (store === 'id' ? id : value);
            window.setAttributes(link, {
                'href': 'javascript:void(0)',
                'class': 'datalist',
                'onclick': 'javascript:selectFromDatalist("' + key + '", "' + final + '", "' + value + '")',
                'value': value
            });
            // Create the container's childs
            container.appendChild(selector);
            selector.appendChild(link);
        }

        // Populate datalist from ajax
        function requestDatalistFromAjax(url, key, min, vars) {
            //Set default values
            let response;
            let search = document.getElementById('input_' + key).value;
            let ajaxUrl = url + '/?store={{ $field->store }}&search=' + search + (vars ? '&' + vars : '');
            var container = document.getElementById('list_' + key);

            //Get ajax response
            if(search && search.length >= min) {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', ajaxUrl , true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.onload = function() {
                    if(xhr.readyState == 4 && xhr.status == 200) {
                        // Empty the container
                        container.innerHTML = "";
                        //Show the container
                        window.toogleContainer(container, 'block');
                        //To json
                        response = JSON.parse( xhr.responseText );
                        // Populate...
                        response.forEach(function(item) {
                            window.createDatalistContainer(container, key, item.value, item.label);
                        });
                    }
                };
                xhr.send();
            }
        }
    </script>
@endpush
