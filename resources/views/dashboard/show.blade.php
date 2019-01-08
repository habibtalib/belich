@extends('belich::layout')

@section('content')
    @foreach($request['fields'] as $field)
        @component('belich::fields.components.inlineForm')
            @slot('label', $field->name)
            @slot('field', $field->value)
        @endcomponent
    @endforeach
@endsection
