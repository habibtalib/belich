@push('javascript')
    <script>
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
            //Default value
            var currentTab;
            // Prevent doubble click
            if(currentTab === key) { return false; }
            //Get all the tabs and containers
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

        //Format number to decimals
        function setDecimals(item, decimals) {
            item.value = parseFloat(item.value).toFixed(decimals);
        }

        //Only allow numeric chars from keyword
        function onlyNumerics(event) {
            return (
                event.ctrlKey || event.altKey
                || (47<event.keyCode && event.keyCode<58 && event.shiftKey==false)
                || (95<event.keyCode && event.keyCode<106)
                || (event.keyCode==8) || (event.keyCode==9)
                || (event.keyCode>34 && event.keyCode<40)
                || (event.keyCode==46)
            );
        }
    </script>
@endpush
