<div class="w-full items-center py-8 px-6 border-b border-grey-lighter shadow-md {{ $field->color ?? 'text-grey-dark' }}  {{ $field->size ?? 'text-base' }} {{ $field->background ?? 'bg-grey-lightest' }}">
    <div class="capitalize font-bold">
        <i class="fas fa-{{ $field->icon ?? 'angle-double-right' }} text-grey-light"></i> {{ $field->label }}
    </div>
</div>
