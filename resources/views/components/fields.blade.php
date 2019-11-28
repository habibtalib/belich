{{-- Conditional field --}}
@if($field->dependsOn)
    @include('belich::components.fields.fieldConditional')
{{-- Regular field --}}
@else
    @include('belich::components.fields.field')
@endif
