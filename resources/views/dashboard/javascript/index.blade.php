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
            function liveSearch(key, query = '', page = 1, orderBy = '', direction = '', filters = '', forceQuery = false) {
                // No filters
                if(forceQuery === false) {
                    // Hide icon
                    if(query.length === 0 || query === '') {
                        window.onSelection('#icon-search-reset-' + key, 'hide');
                    }
                    // Min. search filter
                    if(query.length < minSearch && query.length > 0) {
                        return;
                    }
                }
                // Get value
                var querySearch = window.querySearch(query);
                // Uncheck all the table items
                window.uncheckAll();
                // Loading
                document.getElementById('loading').classList.remove('hidden');
                // Get filters
                var filters = JSON.stringify(getFilters());
                // Set default values
                document.getElementById('live_search_query').value = query;
                document.getElementById('live_search_page').value = page;
                document.getElementById('live_search_order').value = orderBy;
                document.getElementById('live_search_direction').value = direction;
                document.getElementById('live_search_filters').value = filters;
                // Ajax request
                var request = new XMLHttpRequest();
                request.open('GET', '{{ route('dashboard.ajax.search') }}?type=search&tableTextAlign={{ $request->get('tableTextAlign') }}&query=' + querySearch + '&resourceName={{ Belich::resourceName() }}&fields={{ Helper::searchFields() }}&page=' + page + '&orderBy=' + orderBy + '&direction=' + direction + '&filters=' + filters, true);
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
            Description: Live filter
            */
            function liveFilter()
            {
                // Set default values
                window.liveSearch(
                    '{{ Belich::key() }}',
                    document.getElementById('live_search_query').value,
                    document.getElementById('live_search_page').value,
                    document.getElementById('live_search_order').value,
                    document.getElementById('live_search_direction').value,
                    document.getElementById('live_search_filters').value,
                    true
                );
            }

            /*
            Section: Filter
            Description: get all the filters
            */
            function getFilters(separator = '***')
            {
                var filters = [];
                var selects = document.querySelectorAll('select.search-live-filter');
                for (var i = 0; i < selects.length; i++)  {
                    var value = selects[i].value;
                    if(value) {
                        filters.push(selects[i].dataset.filter + separator + selects[i].id  + separator + value);
                    }
                }

                return filters || document.getElementById('live_search_filters').value;
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
