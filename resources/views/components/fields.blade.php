<div class="w-full flex items-center py-8 px-6 bg-white text-gray-600 border-b border-gray-200 text-sm shadow-md">
    <div class="w-1/3">
        <label class="capitalize font-bold">{{ $field->label ?? null }}</label>
    </div>
    <div class="w-2/3 my-auto">
        {{-- Displaying the field --}}
        {{ $input ?? null }}

        @if($field->toDegrees ?? false)
            <div id="{{ md5($field->id . '-to-degrees') }}" class="font-normal lowercase font-bold mt-2 capitalize"></div>
        @endif

        @isset($field->help)
            <div class="font-normal lowercase italic mt-2 uppercase-first-letter">{{ $field->help }}</div>
        @endisset

        @isset($field->id)
            <p id="error-{{ $field->id }}" class="text-red-500 font-normal italic mt-2"></p>
        @endif

        @include('belich::fields.cast')
    </div>
</div>
