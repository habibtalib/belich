@if(isset($request->formType) && $request->formType === 'grid')

@else
    @component('belich::fields.components.inlineForm')
        @slot('label', $request->name)
        @slot('field')
            <div class="select-container">
                <select
                    id="{{ getFieldName($request) }}"
                    name="{{ getFieldName($request) }}"
                    dusk="{{ getFieldName($request) }}"
                >
                    @foreach($request->options as $value => $text)
                        <option value="{{ $value }}" {{ $request->value === $value ? 'selected="selected"' : '' }}>{{ $text }}</option>
                    @endforeach
                </select>
                <div class="icon">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                    </svg>
                </div>
            </div>
        @endslot
    @endcomponent
@endif
