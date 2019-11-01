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
            {{-- From array --}}
            @if($field->responseArray)
                onchange="javascript:createDatalistFromArray(
                    '{{ md5($field->attribute) }}',
                    '{{ $field->attribute }}'
                )"
            @endif
            {{-- From ajax --}}
            @if($field->responseUrl)
                onkeyup="javascript:createDatalistFromAjax(
                    '{{ $field->responseUrl }}',
                    '{{ md5($field->attribute) }}',
                    '{{ $field->minChars }}',
                    '{{ $field->addVars }}',
                    '{{ $field->store }}',
                    '{{ $field->attribute }}'
                );"
            @endif
        >

        {{-- Hidden container with the value for storage --}}
        <input type="hidden" {!! $field->render !!} value="{{ $field->value }}">

        {{-- Response container for ajax --}}
        @if($field->responseUrl)
{{--             <div class="relative">
                <ul id="list_{{ md5($field->attribute) }}" class="absolute left-0 top-0 bg-white border border-t-0 border-gray-400 hidden mb-4"></ul>
            </div> --}}
            <datalist id="list_{{ md5($field->attribute) }}"  class="bg-white border border-t-0 border-gray-400 mb-4">
            </datalist>
        @endif

        {{-- Response container for array --}}
        @if($field->responseArray)
            <datalist id="list_{{ md5($field->attribute) }}"  class="bg-white border border-t-0 border-gray-400 mb-4">
                @foreach($field->responseArray as $value => $text)
                    <option data-text="{{ $text }}" data-value="{{ $value }}">{{ $text }}</option>
                @endforeach
            </datalist>
        @endif

        {{-- Error container --}}
        <p id="error-{{ $field->id }}" class="validation-error"></p>

        {{-- Cast field --}}
        @include('belich::fields.cast')
    </slot>
</belich::fields>

@push('javascript')
    <script>
        // Select value from datalist
        function selectDatalistValue(key, final, value, attribute) {
            //Get the container
            var container = document.getElementById('list_' + key);
            //Hide the container
            window.toogleContainer(container, 'hidden');
            //Add value to inputs
            document.getElementById('input_' + key).value = value;
            document.getElementById(attribute).value = final;
        }

        //Create the datalist container
        function createDatalistContainer(container, key, id, value, store, attribute) {
            // Set the final value
            var final = (store === 'id' ? id : value);
            option = document.createElement('option');
            window.setAttributes(option, {
                'data-text': final,
                'data-result': final,
                'value': value
            });
            container.append(option);

            // // Create a new <li> element
            // var selector = document.createElement('li');
            // selector.setAttribute('class', 'py-4 px-5 border-b border-gray-300');
            // // Create a new <a> element
            // var link = document.createElement('a');
            // // Set the final value
            // var final = (store === 'id' ? id : value);
            // // Set the values
            // window.setAttributes(link, {
            //     'href': 'javascript:void(0)',
            //     'class': 'datalist',
            //     'onclick': 'javascript:selectDatalistValue("' + key + '", "' + final + '", "' + value + '", "' + attribute + '")',
            //     'data-result': final,
            //     'value': value
            // });
            // // Create the container's childs
            // container.appendChild(selector);
            // selector.appendChild(link);
        }

        // Create a dataList from array
        function createDatalistFromArray(key, attribute) {
            var container = document.getElementById('input_' + key);
            var opts = document.getElementById('list_' + key).childNodes;
            for(var i = 0; i < opts.length; i++) {
                if(opts[i].value === container.value) {
                    // Update the value
                    container.value = opts[i].getAttribute('data-text');
                    document.getElementById(attribute).value = opts[i].getAttribute('data-value');
                    break;
                }
            }
        }

        // Populate datalist from ajax
        function createDatalistFromAjax(url, key, min, vars, store, attribute) {
            //Set default values
            let response;
            let search = document.getElementById('input_' + key).value;
            let ajaxUrl = url + '/?store=' + store + '&search=' + search + (vars ? '&' + vars : '');
            var container = document.getElementById('list_' + key);

            //Get ajax response
            if(search && search.length >= min) {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', ajaxUrl , true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.onreadystatechange = function() {
                    if(xhr.readyState == 4 && xhr.status == 200) {
                        // Empty the container
                        container.innerHTML = "";
                        //Show the container
                        window.toogleContainer(container, 'block');
                        //To json
                        response = JSON.parse( xhr.responseText );
                        // Populate...
                        response.forEach(function(item) {
                            window.createDatalistContainer(container, key, item.value, item.label, store, attribute);
                        });
                    }
                };
                xhr.send();
            }
        }
    </script>
@endpush
