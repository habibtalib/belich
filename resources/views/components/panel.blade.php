<div class="form-container">
    {{-- Get all the fields --}}
    @foreach($panel as $key => $field)

        {{-- Render fields: create, edit --}}
        @isset($toField)

            {{-- Render field by type --}}
            @if(View::exists('belich::fields.' . $field->type))
                @include('belich::fields.' . $field->type, ['field' => $field])
            @else
                {{-- Relationship --}}
                @if($field->type === 'relationship')
                    {!! $field->{Belich::action()}() ?? Helper::emptyResults() !!}
                {{-- Text field / Default --}}
                @else
                    @include('belich::fields.text', ['field' => $field])
                @endif
            @endif

        {{-- Render values: show --}}
        @else

            {{-- Only if there is results --}}
            @if(!empty($field->label))
                <belich::fields :field="$field" :toField="$toField ?? null">
                    <slot name="input">
                        {{-- Show as html --}}
                        @if($field->asHtml)
                            {!! $field->value !!}
                        {{-- Show as scaped field --}}
                        @else
                            {{ $field->value }}
                        @endif

                    </slot>
                </belich::fields>
            @endif
        @endif
    @endforeach
</div>
