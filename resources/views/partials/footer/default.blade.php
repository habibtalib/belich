<footer>
    {{-- Load the vendor's scripts --}}
    @mix('app.js')

    {{-- Javascript default values --}}
    <script>
        //Default javascript values
        window._path  = window.location.origin;
        window.minSearch = {{ config('belich.minSearch') ?? 1 }};
        window.message_chart_left = '{{ trans('belich::forms.chart_left') }}';
        window.liveSearchRoute = '{{ route('dashboard.ajax.search') }}';
        window.liveSearchResource = '{{ Belich::resourceName() }}';
        window.liveSearchFields = '{{ Belich::searchFields() }}';

/**
 ****************************************
 * Default javascript methods
 ****************************************
 */
        // Loading button
        function submitForm(item) {
            loading(item);
            item.closest('form').submit();
        }

        // Loading button
        function loading(item, event) {
            item.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        }

        //Close alert with fadeOut
        function closeMenssage(container) {
            //Set container
            var container = document.getElementById('menssage-alert');
            //Set the opacity to 0
            container.style.opacity = '0';
            //Hide the div after 500ms
            setTimeout(function() {container.style.display = 'none';}, 500);
        }

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
            checkForSelectedFields();
        }

         /*
         Section: Table
         Description: Check if there is a field selected
         */
        function checkForSelectedFields()
        {
            //Toogle buttons
            toggleOnSelection('.button-selected', document.querySelectorAll('input[type="checkbox"]:checked.form-index-selector'));
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
            onSelection('#icon-search-reset', 'hide');

            //Reset search
            liveSearch('resetSearchAll');
        }

         /*
         Section: Search
         Description: Show the reset icon when the input is not empty
         */
        function showResetSearch()
        {
            if(document.getElementById('_search').value.length > 0) {
                onSelection('#icon-search-reset', 'show');
            }
        }

         /*
         Section: Form
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
         Section: Form
         Description: Add all the checked checkboxes to the hidden field
         Methods: getCheckboxSelected()
         */
        function addCheckboxesToField(fieldID) {
            return document.getElementById(fieldID).value = getCheckboxSelected();
        }

         /*
         Section: Delete
         Description: Delete the selected fields or all the fields
         Methods: getCheckboxSelected()
         */
        function deleteSelectedFields(fieldID) {
            //Get the selected items
            var items = getCheckboxSelected();
            //Add selected values
            document.getElementById(fieldID).value = items;

            if(items.length <= 0) {
                return false;
            }
        }

         /*
         Section: Delete
         Description: Delete the field
         */
        function deleteField(form, url) {
            document.getElementById(form).setAttribute('action', url);
        }

         /*
         Section: Global
         Description: Toggle container base on item selection
         */
        function toggleOnSelection(selector, items) {
            (items.length <= 0) ? onSelection(selector, 'hide') : onSelection(selector, 'show');
        }

         /*
         Section: Global
         Description: Show or hide container base on item selection
         */
        function onSelection(selector, type)
        {
            var elements = document.querySelectorAll(selector);

            //Show each element
            for (var i = 0; i < elements.length; i++) {
                (type === 'hide')
                    ? elements[i].classList.add('hidden')
                    : elements[i].classList.remove('hidden');
            }
        }

         /*
         Section: Search
         Description: Live search
         */
        function liveSearch(query = '') {

            //Hide icon
            if(query.length === 0) {
                onSelection('#icon-search-reset', 'hide');
            }

            //Min. search filter
            if(query.length < minSearch) {
                return;
            }

            $.ajax({
                url: "{{ route('dashboard.ajax.search') }}",
                method: 'GET',
                data: {
                    query: query,
                    resourceName: '{{ Belich::resourceName() }}',
                    type: 'search',
                    fields: '{{ Belich::searchFields() }}'
                },
                dataType: 'json',
                success: function(data) {
                    $('#tableContainer').html(data);
                }
            })
        }

/**
 ****************************************
 * Form javascript methods
 ****************************************
 */

        /*
        Section: Form
        Description: Count textArea Characters.
        */
        function textAreaCount(container, id) {
            document.getElementById('chars-' + id).innerHTML = window.message_chart_left + ": <b>" + (container.maxLength - container.value.length) + "</b>";
        }

        /*
        Section: Form
        Description: Toggle checkbox
        */
        function toggleCheckbox(id) {
            var container = document.getElementById(id);
            container.value = container.checked == 0 ? 0 : 1;
        }

        /*
        Section: Tabs
        Description: Tabs for forms
        */
        function switchTab(id, key) {

            var currentTab;

            // Prevent doubble click
            if(currentTab === key) {
                return false;
            }

            //Close all tabs
            var elements = document.querySelectorAll('.content');
            var container = document.getElementById('content_' + id);

            //Hide all the containers
            for (var i = 0; i < elements.length; i++) {
                elements[i].classList.add('hidden'), elements[i].classList.remove('block');
            }

            //Set visible
            container.classList.remove('hidden'), container.classList.add('block');

            //Add active
            document.querySelector('.tabs ul li a.active').classList.remove('active');
            document.getElementById('menu_' + id).classList.add('active');

            //Set current tab
            currentTab = key;
        }
    </script>

    {{-- User custom javascript --}}
    @stack('javascript')
</footer>
