<div class="form-container">
    {{-- Get all the fields --}}
    @foreach($panel as $key => $field)

        {{-- Render fields: create, edit --}}
        @isset($toField)

            {{-- Render field by type --}}
            @includeIf('belich::fields.' . $field->type, ['field' => $field])

        {{-- Render values: show --}}
        @else

            {{-- Only if there is results --}}
            @if(!empty($field->label))
                <belich::fields :field="$field" :toField="$toField ?? null">
                    <slot name="input">

                        {{-- Show as html --}}
                        @if($field->asHtml)
                            {!! Belich::html()->resolve($field) !!}
                        {{-- Show as scaped field --}}
                        @else
                            {{ Belich::html()->resolve($field) }}
                        @endif

                    </slot>
                </belich::fields>
            @endif
        @endif
    @endforeach
</div>
