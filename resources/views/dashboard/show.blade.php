@extends('belich::layout')

@section('content')
    @foreach($request as $field)
        @if(!empty($field->name))
            @component('belich::fields.components.inlineForm')
                @slot('label', $field->name)
                @slot('field', $field->value)
            @endcomponent
        @endif
    @endforeach
@endsection
