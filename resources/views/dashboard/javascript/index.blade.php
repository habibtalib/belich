<script>
    /*
    Section: Table
    Description: Check all the fields from the index table
    */
    function checkAll(selector)
    {
        var checkboxes = document.getElementById('belich-index-table').getElementsByTagName('input');
        for (var i=0; i < checkboxes.length; i++)  {
            if (checkboxes[i].type == 'checkbox')   {
                checkboxes[i].checked = (selector.checked === true) ? true : false;
            }
        }
    }

    /*
    Section: Search
    Description: Empty the input value when click on reset icon
    */
    function resetSearch()
    {
        document.getElementById('_search').value = '';
        document.getElementById('icon-search-reset').classList.add('hidden');
    }

    /*
    Section: Search
    Description: show the reset icon when the input is not empty
    */
    function showResetSearch()
    {
        if(document.getElementById('_search').value.length > 0) {
            return document.getElementById('icon-search-reset').classList.remove('hidden');
        }
    }

    /*
    Section: Form
    Description: Select all the checked checkboxes
    */
    function getCheckboxSelected() {
        var listOfCheckedElements = [];
        var elements = document.querySelector('#belich-index-table').querySelectorAll('input[type="checkbox"]');
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
        //Add selected values
        document.getElementById(fieldID).value = getCheckboxSelected();
        //Submit form and delete values
        document.getElementById('belich-form-delete-selected').submit();
    }
</script>
