<script>
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
    Description: Delete the a field
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
