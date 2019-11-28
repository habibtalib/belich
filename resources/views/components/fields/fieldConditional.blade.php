{{-- Conditional field --}}
<div class="conditional-field" data-conditionalParent="{{ $field->dependsOn }}" data-conditionalValue="{{ $field->dependsOnValue }}">
    @include('belich::components.fields.field')
</div>

{{-- Conditional javascript --}}
@section('javascript-conditional')
    <script>
        document.addEventListener('DOMContentLoaded', function(event) {
            window.toggleConditional();
            window.addEventListener('change', toggleConditional, false);
        });

        // Toogle field container
        function toggleConditional() {
            // window.addEventListener('change', conditionalListener, false);
            var fields = document.querySelectorAll('.conditional-field');
            // Check all the parents
            for (var i = 0; i < fields.length; i++)  {
                // Looking for parents
                var parentId = fields[i].getAttribute('data-conditionalParent');
                var parentValue = fields[i].getAttribute('data-conditionalvalue');
                // Render fields
                window.toggleConditionalField(parentId, fields[i]);
            }
        }

        // Toggle container base on parent value
        function toggleConditionalField(parent, field) {
            // For views: create and edit
            if(document.getElementById(parent)) {
                parentValue = document.getElementById(parent).value || 0;
            // For view: show
            } else {
                parentValue = document.querySelector('[data-baseAttribute="' + parent + '"]').getAttribute('data-baseValue') || 0;
            }

            parentValue == 0
                ? field.classList.add('hidden')
                : field.classList.remove('hidden');
        }
    </script>
@endsection
