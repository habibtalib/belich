<div class="w-full items-center py-8 px-6 border-b border-gray-200 shadow-md {{ $field->color ?? 'text-gray-600' }}  {{ $field->size ?? 'text-base' }} {{ $field->background ?? 'bg-gray-100' }}">
    <div class="capitalize font-bold">
        <i class="fas fa-{{ $field->icon ?? 'angle-double-right' }} {{ $field->color }} opacity-75"></i> {{ $field->label }}
    </div>
</div>
