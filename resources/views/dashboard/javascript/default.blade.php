{{-- Javascript default values --}}
<script>
    //Default javascript values
    window._path  = window.location.origin;
    window.minSearch = {{ config('belich.liveSearch.minChars') ?? 1 }};
    window.message_chart_left = '{{ trans('belich::forms.chart_left') }}';
    window.liveSearchRoute = '{{ route('dashboard.ajax.search') }}';
    window.resourceName = '{{ Belich::resourceName() }}';
    window.liveSearchFields = '{{ Belich::searchFields() }}';

    /**
    ****************************************
    * Ajax javascript methods
    ****************************************
    */
    //Generate the validation request for AJAX
    function responseAjaxRequest(request) {
        return {
            method: 'POST',
            credentials: 'same-origin',
            body: request,
            headers: responseAjaxHeaders()
        };
    }

    //Get csrf-token
    function csrfToken() {
        return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    }

    //Set the headers response
    function responseAjaxHeaders() {
        return {
            "Content-Type": "application/json",
            "Accept": "application/json, text-plain",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": csrfToken()
        };
    }

    /**
    ****************************************
    * Default javascript methods
    ****************************************
    */
    // Load js script to head
    function loadScript(src, done) {
        var js = document.createElement('script');
        js.src = src;
        js.onload = function() {
            done();
        };
        js.onerror = function() {
            done(new Error('Failed to load script ' + src));
        };
        document.head.appendChild(js);
    }

    // browser support for fetch
    function browserSupportsFetch() {
        return window.Promise && window.fetch && window.Symbol;
    }

    // Loading button
    function submitForm(item) {
        window.loading(item);
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

    //Add attributes to elements
    function setAttributes(element, attrs) {
        for(var key in attrs) {
            if(key === 'value') {
                element.innerHTML = attrs[key];
            } else {
                element.setAttribute(key, attrs[key]);
            }
        }
    }

    // Show or hide a container
    function toogleContainer(container, value) {
        container.classList.remove('hidden', 'block');
        container.classList.add(value);
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
        window.checkForSelectedFields();
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
</script>
