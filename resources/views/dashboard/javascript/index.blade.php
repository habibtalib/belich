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
            function liveSearch(query = '', page = 1, orderBy = '', direction = '') {
                //Hide icon
                if(query.length === 0) {
                    window.onSelection('#icon-search-reset', 'hide');
                }
                //Min. search filter
                if(query.length < minSearch && query.length > 0) {
                    return;
                }
                //Uncheck all the table items
                window.uncheckAll();
                //Ajax request
                var request = new XMLHttpRequest();
                var querySearch = query || 'resetSearchAll';
                request.open('GET', '{{ route('dashboard.ajax.search') }}?type=search&tableTextAlign={{ $request->get('tableTextAlign') }}&query=' + querySearch + '&resourceName={{ Belich::resourceName() }}&fields={{ Helper::searchFields() }}&page=' + page + '&orderBy=' + orderBy + '&direction=' + direction, true);
                request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                request.onload = function() {
                    if (this.status == 200 && this.readyState == 4) {
                        document.getElementById('table-container').innerHTML = JSON.parse(this.response);
                    }
                };
                request.send();
            }

             /*
             Section: Search
             Description: Empty the input value when click on reset icon
             */
            function resetSearch()
            {
                //Reset value
                document.getElementById('_search').value = '';

                //Hide icon
                window.onSelection('#icon-search-reset', 'hide');

                //Reset search
                window.liveSearch('resetSearchAll');
            }

             /*
             Section: Search
             Description: Show the reset icon when the input is not empty
             */
            function showResetSearch()
            {
                if(document.getElementById('_search').value.length > 0) {
                    window.onSelection('#icon-search-reset', 'show');
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
                var elements = document.querySelector('#belich-index-table').querySelectorAll('input[type="checkbox"]');
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

            {{-- Custom jquery --}}
            document.addEventListener('DOMContentLoaded', function(event) {
                //live search
                if(document.getElementById('_search')) {
                    document.getElementById('_search')
                        .addEventListener('keyup', function(event) {
                            window.liveSearch(this.value);
                        });
                }
            });
        </script>
    @endif
@endpush
