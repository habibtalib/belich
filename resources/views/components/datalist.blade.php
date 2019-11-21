<belich::fields :field="$field">
    <slot name="input">
        {{-- Set the autocomplete (visible) container --}}
        <input
            id="input_{{ $key }}"
            list="list_{{ $key }}"
            type="text"
            dusk="datalist-input-{{ $id }}"
            {!! Helper::formAttribute($field, 'addClass') !!}
            {!! Helper::formAttribute($field, 'value', $field->defaultValue ?? null) !!}
            {!! $field->render !!}
            @if($field->responseArray)
                onchange="javascript:setDatalistValuesFromArray('{{ $id }}', '{{ $key }}', '{{ $store }}')"
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
        <input type="hidden" name="{{ $id }}" dusk="datalist-{{ $id }}" {!! $field->render !!} value="{{ $field->valueRelationship ?? $field->value }}">

        {{-- Array response --}}
        @if($field->responseArray)
            <datalist id="list_{{ $key }}" dusk="datalist-info-{{ $id }}" class="datalist">
                @foreach($field->responseArray as $value => $text)
                    <option data-text="{{ $text }}" data-value="{{ $value }}">
                        {{ $text }}
                    </option>
                @endforeach
            </datalist>
        {{-- Ajax response --}}
        @else
            <div class="relative">
                <ul id="list_{{ $key }}" dusk="datalist-info-{{ $id }}" class="datalist hidden rounded shadow-md"></ul>
            </div>
        @endif

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
        //Close datalist when click outside the container
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
        function setDatalistValuesFromAjax(field, key, text, value) {
            //Toogle container
            toogleContainer(document.getElementById('list_' + key), 'hidden');
            // Set values
            document.getElementById(field).value = value;
            document.getElementById('input_' + key).value = text;
        }

        // Get the values from the datalist (array)
        function setDatalistValuesFromArray(field, key, store) {
            // Get values
            var input = document.getElementById('input_' + key);
            var datalist = document.getElementById('list_' + key).childNodes;
            // Search datalist values
            for(var i = 0; i < datalist.length; i++) {
                if(datalist[i].value === input.value) {
                    // Update the value
                    input.value = datalist[i].dataset.text;
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
            var datalist = document.getElementById('list_' + key);
            var search = input.value;
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
                        datalist.innerHTML = "";
                        // Show the container
                        window.toogleContainer(datalist, 'block');
                        // Add setAttributes
                        JSON.parse(request.responseText).forEach(function(item) {
                            // Set values
                            var finalValue = window.setValueToStore(item.value, item.label, store);
                            // Create the <li>
                            var li = document.createElement('li');
                            window.setAttributes(li, {
                                'data-text': item.label,
                                'data-value': finalValue,
                                'onclick': "javascript:setDatalistValuesFromAjax('" + field + "', '" + key + "', '" + item.label + "', '" + finalValue + "')",
                                'value': item.label,
                            });
                            datalist.append(li);
                        });
                    }
                };
                // Send response
                request.send();
            }
        }
    </script>
@endsection
