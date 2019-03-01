<script>
    /*
    Section: Form
    Description: Count textArea Characters.
    */
    function textAreaCount(container, id) {
        var message = '{{ trans('belich::forms.chart_left') }}';
        document.getElementById('chars-' + id).innerHTML = message + ": <b>" + (container.maxLength - container.value.length + 1) + "</b>";
    }
</script>
