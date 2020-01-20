@push('javascript')
    <script>
        /**
        ****************************************
        * Form javascript methods
        ****************************************
        */

        // Submit form
        function submitForm(item) {
            window.loading(item);
            item.closest('form').submit();
        }

        //Count textArea Characters
        function textAreaCount(container, id) {
            document.getElementById('chars-' + id).innerHTML = window.message_chart_left + ": <b>" + (container.maxLength - container.value.length) + "</b>";
        }

        //Toggle checkbox
        function toggleCheckbox(id) {
            var container = document.getElementById(id);
            container.value = container.checked == 0 ? 0 : 1;
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
