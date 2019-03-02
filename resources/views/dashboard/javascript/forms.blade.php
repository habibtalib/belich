<script>
    /*
    Section: Form
    Description: Count textArea Characters.
    */
    function textAreaCount(container, id) {
        var message = '{{ trans('belich::forms.chart_left') }}';
        document.getElementById('chars-' + id).innerHTML = message + ": <b>" + (container.maxLength - container.value.length) + "</b>";
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
    function switchTab(tab_id, tab_content) {

    }
</script>
