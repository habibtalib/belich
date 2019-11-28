{{-- Conditional panel --}}
@if($field->dependsOn)
    <div class="conditional-field" data-conditionalParent="{{ $field->dependsOn }}" data-conditionalValue="{{ $field->dependsOnValue }}">
@endif
    {{-- Header fixer --}}
    <div class="form-item-field w-full flex items-center py-8 px-6
        bg-{{ $field->type === 'header' && isset($field->background) ? $field->background : 'white' }}
        text-{{ $field->type === 'header' && isset($field->color) ? $field->color : 'gray-600' }}
        border-b border-gray-200 text-sm shadow-md"
    >
        <div class="w-1/3">
            <label class="capitalize font-bold">{{ $field->label ?? null }}</label>
        </div>
        <div class="w-2/3 my-auto">
            {{-- Displaying the field --}}
            {{ $input ?? null }}

            @if($field->toDegrees ?? false)
                <div id="toDegrees-{{ $field->uriKey }}" class="font-normal lowercase font-bold mt-2 capitalize"></div>
            @endif

            @isset($field->info)
                <div dusk="info-{{ $field->id }}" class="font-semibold mt-2 p-2 bg-blue-100 text-blue-600">
                    <i class="fas fa-info-circle mr-2 text-blue-300"></i> {!! $field->info !!}
                </div>
            @endisset

            @isset($field->help)
                <div dusk="help-{{ $field->id }}" class="font-normal lowercase italic mt-2 p-2 uppercase-first-letter">{!! $field->help !!}</div>
            @endisset

            @isset($field->id)
                <p id="error-{{ $field->id }}"
                    class="validation-error text-red-500 font-normal italic mt-2"
                    @isset($field->tabulationID)
                        data-tab="{{ $field->tabulationID }}"
                    @endisset
                >
                </p>
            @endif

            @include('belich::fields.cast')
        </div>
    </div>

{{-- Conditional panel --}}
@if($field->dependsOn)
    </div>

    @section('javascript-conditional')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // var conditionalContainers = document.querySelectorAll('.conditional-field');
                // for (var i = 0; i < conditionalContainers.length; i++)  {
                //     var getParentId = conditionalContainers[i].getAttribute('data-conditionalParent');
                //     var getParentValue = document.getElementById(getParentId).value;
                //     if(getParentValue) {
                //         conditionalContainers[i].classList.add('hidden');
                //     } else {
                //         conditionalContainers[i].classList.remove('hidden');
                //     }
                // }
                window.addEventListener('change', conditionalListener, false);
            });

            var conditionalListener = function(event) {
                // Set event target
                var eventTarget = event.target.getAttribute('id');
                // Get all the conditional containers
                var conditionalContainers = document.querySelectorAll('.conditional-field');
                // Set the parent list
                var parentList = [];
                // Check all the parents
                for (var i = 0; i < conditionalContainers.length; i++)  {
                    // Looking for parents
                    var item = conditionalContainers[i].getAttribute('data-conditionalParent');
                    if (parentList.indexOf(item) == -1) {
                        parentList.push(item);
                    }
                }
                // Check if the event is in the parentList
                if (parentList.indexOf(eventTarget) != -1) {
                    //Get the parent value
                    var getParentValue = document.getElementById(eventTarget).value;
                    // Check all the childs
                    for (var i = 0; i < conditionalContainers.length; i++)  {
                        if(getParentValue == 0) {
                            console.log('hide');
                            conditionalContainers[i].classList.add('hidden');
                        } else {
                            console.log('show');
                            conditionalContainers[i].classList.remove('hidden');
                        }
                    }
                }
            }
        </script>
    @endsection
@endif
