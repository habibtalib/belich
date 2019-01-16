@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.breadcrumbs')

    @foreach($request as $field)
        @if(!empty($field->name))
            @component('belich::fields.components.inlineForm')
                @slot('label', $field->name)
                @slot('field', $field->value)
            @endcomponent
        @endif
    @endforeach
@endsection
