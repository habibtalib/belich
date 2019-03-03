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
    var currentTab;

    function switchTab(id, key) {

        // Prevent doubble click
        if(currentTab === key) {
            return false;
        }

        //Close all tabs
        var elements = document.querySelectorAll('.content');
        var container = document.getElementById('content_' + id);

        //Hide all the containers
        for (var i = 0; i < elements.length; i++) {
            elements[i].classList.toggle('hidden');
            elements[i].classList.toggle('block');
        }

        //Add active
        document.querySelector('.tabs ul li a.active').classList.remove('active');
        document.getElementById('menu_' + id).classList.add('active');

        //Set current tab
        currentTab = key;
    }

    /*
    Section: Form
    Description: Limit decimal in inputs
    Example: <input class="fixed" type="text" decimals="2" />
    */
    var floatInputs = document.querySelectorAll('.float');

    floatInputs.forEach(function(element) {
        element.addEventListener('input', function() {
            var decimals = element.getAttribute('decimals');
            var regex = new RegExp('(\\.\\d{' + decimals + '})\\d+', 'g');
            element.value = element.value.replace(regex, '$1');
        });
    });
</script>
