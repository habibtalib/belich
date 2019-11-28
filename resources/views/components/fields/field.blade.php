{{-- Header fixer --}}
<div class="form-item-field w-full flex items-center py-8 px-6
    bg-{{ $field->type === 'header' && isset($field->background) ? $field->background : 'white' }}
    text-{{ $field->type === 'header' && isset($field->color) ? $field->color : 'gray-600' }}
    border-b border-gray-200 text-sm shadow-md"
>
    <div class="w-1/3">
        <label class="capitalize font-bold">{{ $field->label ?? null }}</label>
    </div>
    <div class="w-2/3 my-auto" data-baseAttribute="{{ $field->id ?? '' }}"  data-baseValue="{{ $field->value ?? '' }}">
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
