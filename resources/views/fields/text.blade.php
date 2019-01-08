@if(isset($request->formType) && $request->formType === 'grid')

@else
    @component('belich::fields.components.inlineForm')
        @slot('label', $request->name)
        @slot('field')
            <input
                id="{{ getFieldName($request) }}"
                name="{{ getFieldName($request) }}"
                dusk="{{ getFieldName($request) }}"
                type="text"
                value="{{ $request->value ?? null }}"
            >
        @endslot
    @endcomponent
@endif
