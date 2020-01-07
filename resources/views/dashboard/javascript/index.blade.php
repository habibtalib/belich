@push('javascript')
    {{-- Include metrics --}}
    @hasMetrics($request ?? null)

        {{-- Load the javascript lib --}}
        {!! Chart::assets('js') !!}

        {{-- Custom charts --}}
        @mix('charts.legends.min.js')

        {{-- Default scripts --}}
        <script>
            {{-- Create a container for each metric item --}}
            @stack('javascript-metrics')
        </script>
    @endif

    {{-- Include life search --}}
    @if(config('belich.liveSearch.enable'))
        <script>
            /**
            ****************************************
            * Index javascript methods
            ****************************************
            */

            /*
            Section: Search
            Description: Live search
            */
            function liveSearch(key, query = '', page = 1, orderBy = '', direction = '') {
                // Hide icon
                if(query.length === 0 || query === '') {
                    window.onSelection('#icon-search-reset-' + key, 'hide');
                }
                // Min. search filter
                if(query.length < minSearch && query.length > 0) {
                    return;
                }
                // Get value
                var querySearch = window.querySearch(query);
                // Avoid duplicate searchs
                if(!window.dataCheck(key, querySearch, page, orderBy, direction)) {
                    return false;
                }
                // Uncheck all the table items
                window.uncheckAll();
                // Loading
                document.getElementById('loading').classList.remove('hidden');
                // Ajax request
                var request = new XMLHttpRequest();
                request.open('GET', '{{ route('dashboard.ajax.search') }}?type=search&tableTextAlign={{ $request->get('tableTextAlign') }}&query=' + querySearch + '&resourceName={{ Belich::resourceName() }}&fields={{ Helper::searchFields() }}&page=' + page + '&orderBy=' + orderBy + '&direction=' + direction, true);
                request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                request.onload = function() {
                    if (this.status == 200 && this.readyState == 4) {
                        document.getElementById('index-table-' + key).innerHTML = JSON.parse(this.response);
                        document.getElementById('loading').classList.add('hidden');
                    }
                };
                request.send();
            }

            /*
            Section: Search
            Description: Add reset value for search if needed...
            */
            function querySearch(query = '')
            {
                return query.length <= 0
                    ? 'resetSearchAll'
                    : query;
            }

            /*
            Section: Search
            Description: Add reset value for search if needed...
            */
            function dataCheck(key, query, page, orderBy, direction)
            {
                var data = document.getElementById('search-' + key).getAttribute('data-search');
                var queryCheck = query + '-' + orderBy + '-' + direction;
                var status = data !== queryCheck;
                // Update data
                document.getElementById('search-' + key).setAttribute('data-search', queryCheck);

                return status;
            }

             /*
             Section: Search
             Description: Empty the input value when click on reset icon
             */
            function resetSearch(key)
            {
                //Reset value
                document.getElementById('search-' + key).value = '';

                //Hide icon
                window.onSelection('#icon-search-reset-' + key, 'hide');

                //Reset search
                window.liveSearch(key, 'resetSearchAll');
            }

             /*
             Section: Search
             Description: Show the reset icon when the input is not empty
             */
            function showResetSearch(key)
            {
                if(document.getElementById('search-' + key).value.length > 0) {
                    window.onSelection('#icon-search-reset-' + key, 'show');
                }
            }

             /*
             Section: Table
             Description: Check all the fields from the index table
             */
            function checkAll(selector)
            {
                var checkboxes = document.querySelectorAll('input[type="checkbox"].form-index-selector');
                for (var i=0; i < checkboxes.length; i++)  {
                    if (checkboxes[i].type == 'checkbox')   {
                       checkboxes[i].checked = (selector.checked === true) ? true : false;
                   }
               }
                //Toogle buttons
                window.checkForSelectedFields();
            }

            /*
            Section: Table
            Description: Uncheck all the fields from the index table
            */
            function uncheckAll()
            {
                var checkboxes = document.getElementsByTagName('input[type="checkbox"].form-index-selector');
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox') {
                        checkboxes[i].checked = false;
                    }
                }
                //Toogle buttons
                window.onSelection('.button-selected', 'hide');
            }

             /*
             Section: Table
             Description: Check if there is a field selected
             */
            function checkForSelectedFields()
            {
                //Toogle buttons
                window.toggleOnSelection('.button-selected', document.querySelectorAll('input[type="checkbox"]:checked.form-index-selector'));
            }

             /*
             Section: Table
             Description: Select all the checked checkboxes
             */
            function getCheckboxSelected() {
                //Reset the elements list
                var listOfCheckedElements = [];
                //Get all the checked elements
                var elements = document.querySelector('#index-table-{{ Belich::key() }}').querySelectorAll('input[type="checkbox"]');
                //Add all the elements to the list
                for (var i = 0; i < elements.length; i++) {
                    if(elements[i].checked) {
                        listOfCheckedElements[i] = elements[i].value;
                    }
                }
                return listOfCheckedElements;
            }

             /*
             Section: Table
             Description: Add all the checked checkboxes to the hidden field
             Methods: getCheckboxSelected()
             */
            function addCheckboxesToField(fieldID) {
                return document.getElementById(fieldID).value = getCheckboxSelected();
            }

             /*
             Section: Table
             Description: Delete the selected fields or all the fields
             Methods: getCheckboxSelected()
             */
            function deleteSelectedFields(fieldID) {
                //Get the selected items
                var items = window.getCheckboxSelected();
                //Add selected values
                document.getElementById(fieldID).value = items;

                if(items.length <= 0) {
                    return false;
                }
            }

             /*
             Section: Table
             Description: Delete the field
             */
            function deleteField(form, url) {
                document.getElementById(form).setAttribute('action', url);
            }
        </script>
    @endif
@endpush
