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
    function switchTab(currentLink, container) {
        //Close all tabs
        var elements = document.querySelectorAll('.content');
        var container = document.getElementById('content_' + container);

        //Hide all the containers
        for (var i = 0; i < elements.length; i++) {
            elements[i].classList.toggle('hidden');
            elements[i].classList.toggle('block');
        }

        //Add active
        document.querySelector('.tabs ul li a.active').classList.remove('active');
        document.getElementById(currentLink).classList.add('active');
    }
</script>
