{{-- Custom html --}}
@if($field->asHtml === true)
    {!! $field->label !!}
@else
    {{-- Custom color --}}
    @if($field->color)
        <div class="w-full items-center py-5 px-6 font-bold text-white bg-{{ $field->color ?? 'blue' }}-500">
    {{-- Default color --}}
    @else
        <div class="w-full items-center py-5 px-6 font-bold text-gray-600 bg-gray-200">
    @endif
            {{ $field->label }}
        </div>
@endif
