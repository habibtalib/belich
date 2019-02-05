@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.breadcrumbs')

    @foreach($fields as $field)
        @if(!empty($field->label))
            @component('belich::fields.components.inlineForm')
                @slot('label', $field->label)
                @slot('field', Utils::value($field))
            @endcomponent
        @endif
    @endforeach
@endsection
