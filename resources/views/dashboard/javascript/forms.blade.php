@push('javascript')
    <script>
        {{-- Custom jquery --}}
        document.addEventListener('DOMContentLoaded', function(event) {
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
        });
    </script>
@endpush
