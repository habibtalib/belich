@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.navigation.breadcrumbs')

    {{-- Buttons --}}
    <div class="flex w-full justify-end">
        <a href="{{ Belich::actionRoute('edit', $request->id) }}" class="btn btn-secondary mb-4">
            @icon('edit', 'belich::buttons.crud.update')
        </a>
    </div>

    @foreach($request->fields as $field)
        @if(!empty($field->label))
            <div class="form-container">
                @component('belich::fields.components.inlineForm')
                    @slot('label', $field->label)
                    @slot('field')
                        {!! Belich::html()->resolve($field) !!}
                    @endslot
                @endcomponent
            </div>
        @endif
    @endforeach
    {{-- Form border rounded --}}
    @include('belich::partials.form-rounded', ['height' => 'h-16'])
@endsection
