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
        @include('belich::dashboard.javascript.search')
    @endif

    {{-- General javascript --}}
    <script>
        /**
        ****************************************
        * Index javascript methods
        ****************************************
        */

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
@endpush
