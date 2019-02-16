@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.breadcrumbs')

    {{-- Buttons --}}
    @can('update', $autorizedModel)
        <div class="flex w-full justify-end">
            <a href="{{ Belich::actionRoute('edit', $request->id) }}" class="btn btn-secondary mb-4">
                @icon('edit', 'belich::buttons.crud.update')
            </a>
        </div>
    @endcan

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
@endsection
