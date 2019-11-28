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

        function toggleConditional() {
            // window.addEventListener('change', conditionalListener, false);
            var fields = document.querySelectorAll('.conditional-field');
            // Check all the parents
            for (var i = 0; i < fields.length; i++)  {
                // Looking for parents
                var parentId = fields[i].getAttribute('data-conditionalParent');
                var parentValue = fields[i].getAttribute('data-conditionalvalue');
                if(document.getElementById(parentId).value == 0) {
                    fields[i].classList.add('hidden');
                } else {
                    fields[i].classList.remove('hidden');
                }
            }
        }
    </script>
@endsection
