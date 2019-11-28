{{-- Conditional field --}}
<div class="conditional-field" data-conditionalParent="{{ $field->dependsOn }}" data-conditionalValue="{{ $field->dependsOnValue }}">
    @include('belich::components.fields.field')
</div>

{{-- Conditional javascript --}}
@section('javascript-conditional')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            window.addEventListener('change', conditionalListener, false);
        });

        // Conditional listener
        function conditionalListener(event) {
            // Set event target
            var eventTarget = event.target.getAttribute('id');
            // Get all the conditional containers
            var conditionalContainers = document.querySelectorAll('.conditional-field');
            // Get the parent list
            var parentList = window.parentList(conditionalContainers);
            // Check if the event is in the parentList
            if (parentList.indexOf(eventTarget) != -1) {
                // Toggle container
                window.toggleConditionalContainer(conditionalContainers, eventTarget);
            }
        }

        // Get parent fields to listen
        function parentList(container, parent = []) {
            // Check all the parents
            for (var i = 0; i < container.length; i++)  {
                // Looking for parents
                var item = container[i].getAttribute('data-conditionalParent');
                // Verify parents
                if (parent.indexOf(item) == -1) {
                    parent.push(item);
                }
            }
            return parent;
        }

        // Show or hide container
        function toggleConditionalContainer(container, target) {
            // Check all the childs
            for (var i = 0; i < container.length; i++)  {
                if(document.getElementById(target).value == 0) {
                    container[i].classList.add('hidden');
                } else {
                    container[i].classList.remove('hidden');
                }
            }
        }
    </script>
@endsection
