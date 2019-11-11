{{-- Custom html --}}
@if($field->asHtml === true)
    {!! $field->label !!}
@else
    <div class="w-full items-center py-5 px-6 font-bold text-{{ $field->color }} bg-{{ $field->background }}">
        {{ $field->label }}
    </div>
@endif
