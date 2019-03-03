<div class="form-container {{ ($loop->first || Belich::tabs()) ? '' : 'mt-4' }} {{ ($loop->last || Belich::tabs()) ? '' : 'mb-4' }}">
    {{-- Label --}}
    @if(!empty($label) && !Belich::tabs())
        <h4 class="p-6 text-grey-darker uppercase border-b border-grey-lighter">{{ $label }}</h4>
    @endif

    {{-- Get all the fields --}}
    @foreach($panel as $field)

        {{-- Render fields: create, edit --}}
        @isset($toField)

            {{-- Render field by type --}}
            @includeIf('belich::fields.' . $field->type, ['field' => $field])

        {{-- Render values: show --}}
        @else

            {{-- Only if there is results --}}
            @if(!empty($field->label))
                <belich::fields :label="$field->label">
                    <slot name="field">

                        {{-- Enable or disable html scape --}}
                        @if($field->asHtml)
                            {!! Belich::html()->resolve($field) !!}
                        @else
                            {{ Belich::html()->resolve($field)}}
                        @endif

                    </slot>
                </belich::fields>
            @endif
        @endif
    @endforeach
</div>
