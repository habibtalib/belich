@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.navigation.breadcrumbs')

    {{-- Crud Button: edit --}}
    @component('belich::components.crud-button')
        @slot('url', Belich::actionRoute('edit', $request->id))
        @slot('icon', icon('eye', trans('belich::buttons.crud.update')))
    @endcomponent

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
    @include('belich::partials.containers.rounded-bottom', ['height' => 'h-16'])
@endsection
