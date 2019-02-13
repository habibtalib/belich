@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.breadcrumbs')

    {{-- Buttons --}}
    <div class="table-search flex items-center">
        <div class="flex w-full justify-end">
            <a href="{{ Belich::actionRoute('edit', $request->id) }}" class="btn btn-primary">
                @icon('edit', 'belich::buttons.crud.update')
            </a>
        </div>
    </div>

    @foreach($request->fields as $field)
        @if(!empty($field->label))
            <div class="form-container">
                @component('belich::fields.components.inlineForm')
                    @slot('label', $field->label)
                    @slot('field', Belich::blade()->resolveField($field))
                @endcomponent
            </div>
        @endif
    @endforeach
@endsection
