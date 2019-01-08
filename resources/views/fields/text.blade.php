@if(isset($request->formType) && $request->formType === 'grid')

@else
    @component('belich::fields.components.inlineForm')
        @slot('label', $request->name)
        @slot('field')
            <input class="bg-grey-lighter appearance-none border-2 border-grey-lighter rounded w-full py-2 px-4 text-grey-darker leading-tight focus:outline-none focus:bg-white focus:border-purple"
                id="{{ getFieldName($request) }}"
                name="{{ getFieldName($request) }}"
                dusk="{{ getFieldName($request) }}"
                type="text"
                value="Jane Doe">
        @endslot
    @endcomponent
@endif
