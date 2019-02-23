<script>
    {{-- Check all checkboxes --}}
    function checkAll(selector) {
        var checkboxes = document.getElementById('belich-index-table').getElementsByTagName('input');
        for (var i=0; i < checkboxes.length; i++)  {
            if (checkboxes[i].type == 'checkbox')   {
                checkboxes[i].checked = (selector.checked === true) ? true : false;
            }
        }
    }

    {{-- Search fields --}}
    function resetSearch() {
        document.getElementById('_search').value = '';
        document.getElementById('icon-search-reset').classList.add('hidden');
    }
    function showResetSearch() {
        if(document.getElementById('_search').value.length > 0) {
            return document.getElementById('icon-search-reset').classList.remove('hidden');
        }
    }

    {{-- Add checked checkboxes to hidden field --}}
    function addCheckboxesToField(fieldID) {
        return document.getElementById(fieldID).value = getCheckboxSelected();
    }
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

    {{-- Delete selected fields --}}
    function deleteSelectedFields(fieldID) {
        //Add selected values
        document.getElementById(fieldID).value = getCheckboxSelected();
        //Submit form and delete values
        document.getElementById('belich-form-delete-selected').submit();
    }
</script>
