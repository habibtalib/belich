@extends('belich::layout')

@section('content')
    @foreach($request['fields'] as $field)
        @if(!empty($field->name))
            @component('belich::fields.components.inlineForm')
                @slot('label', $field->name)
                @slot('field', getValueForDetailed($request, $field))
            @endcomponent
        @endif
    @endforeach
@endsection
