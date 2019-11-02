<belich::fields :field="$field">
    <slot name="input">
        {{-- Set the autocomplete (visible) container --}}
        <input
            id="input_{{ $key }}"
            list="list_{{ $key }}"
            type="text"
            dusk="dusk-autocomplete-{{ $id }}"
            {!! setAttribute($field, 'addClass') !!}
            {!! setAttribute($field, 'value') !!}
            {!! $field->render !!}
            @if($field->responseArray)
                onchange="javascript:getDatalistValuesFromArray('{{ $id }}', '{{ $key }}', '{{ $store }}')"
            @endif
            @if($field->responseUrl)
                onkeyup = "javascript:datalistAjaxResponse(
                    '{{ $id }}',
                    '{{ $key }}',
                    '{{ $field->responseUrl }}',
                    '{{ $field->addVars }}',
                    '{{ $min }}',
                    '{{ $store }}',
                )"
            @endif
        >

        {{-- Hidden container with the value for storage --}}
        <input type="hidden" {!! $field->render !!} value="{{ $field->value }}">

        {{-- Array response --}}
        @if($field->responseArray)
            <datalist id="list_{{ $key }}" class="datalist">
                @foreach($field->responseArray as $value => $text)
                    <option
                        data-text = "{{ $text }}"
                        data-value = "{{ $value }}"
                    >
                        {{ $text }}
                    </option>
                @endforeach
            </datalist>
        {{-- Ajax response --}}
        @else
            <div class="relative">
                <ul id="list_{{ $key }}" class="datalist hidden rounded shadow-md"></ul>
            </div>
        @endif

        {{-- Error container --}}
        <p id="error-{{ $id }}" class="validation-error"></p>

        {{-- Cast field --}}
        @include('belich::fields.cast')
    </slot>
</belich::fields>

@section('css-no-repeat')
    <style>
        .datalist {
            position: absolute;
            top: 0;
            left: 0;
            margin-top: 1px;
            z-index: 1000;
            margin-bottom: 1rem;
            min-width: 100%;
            background-color: #ffffff;
            border: 1px solid var(--20);
            border-top: 0;
            color: #4a5568;
            font-weight: bold;
        }

        .datalist li {
            padding: 1.25rem 1rem;
        }

        .datalist li:hover {
            background-color: var(--5);
            cursor: pointer;
        }
    </style>
@endsection

@push('javascript')
    <script>
        document.addEventListener('click', function(e) {
            if (!document.getElementById('list_{{ $key }}').contains(e.target)) {
                window.toogleContainer(document.getElementById('list_{{ $key }}'), 'hidden');
            }
        });
    </script>
@endpush

@section('javascript-no-repeat')
    <script>
        // Get the values from the datalist (ajax)
        function getDatalistValuesFromAjax(field, key, text, value) {
            document.getElementById(field).value = value;
            document.getElementById('input_' + key).value = text;
            toogleContainer(document.getElementById('list_' + key), 'hidden');
        }

        // Get the values from the datalist (array)
        function getDatalistValuesFromArray(field, key, store) {
            var input = document.getElementById('input_' + key);
            var datalist = document.getElementById('list_' + key).childNodes;
            for(var i = 0; i < datalist.length; i++) {
                if(datalist[i].value === input.value) {
                    // Update the value
                    input.value = datalist[i].getAttribute('data-text');
                    document.getElementById(field).value = setValueToStore(datalist[i].dataset.value, datalist[i].dataset.text, store);
                    break;
                }
            }
        }

        // Store value or id ($field->storeId())
        function setValueToStore(id, value, store) {
            return store === 'id'
                ? id
                : value;
        }

        // Populate a datalist from ajax
        function datalistAjaxResponse(field, key, url, addVars, min, store) {
            // Default values
            var input = document.getElementById('input_' + key);
            var search = input.value;
            var ul = document.getElementById('list_' + key);
            // Set ajax request
            var request = new XMLHttpRequest();
            var ajaxUrl = url + '/?store=' + store + '&search=' + search + (addVars ? '&' + addVars : '');
            // Ajax response
            if(search && search.length >= min) {
                request.open('GET', ajaxUrl , true);
                request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                request.onreadystatechange = function() {
                    if(request.readyState == 4 && request.status == 200) {
                        // Empty the container
                        ul.innerHTML = "";
                        // Show the container
                        window.toogleContainer(ul, 'block');
                        // Add setAttributes
                        JSON.parse(request.responseText).forEach(function(item) {
                            // Set values
                            var finalValue = window.setValueToStore(item.id, item.label, store);
                            // Create the <li>
                            var li = document.createElement('li');
                            window.setAttributes(li, {
                                'data-text': item.label,
                                'data-value': finalValue,
                                'onclick': "javascript:getDatalistValuesFromAjax('" + field + "', '" + key + "', '" + item.label + "', '" + finalValue + "')",
                                'value': item.label,
                            });
                            ul.append(li);
                        });
                    }
                };
                // Send response
                request.send();
            }
        }
    </script>
@endsection
