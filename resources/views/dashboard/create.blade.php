@extends('belich::layout')

<form name="form-create" id="form-create" method="POST" action="">
    @csrf
    @foreach($request as $field)
        @includeIf('belich::fields.' . $field->type, ['field' => $field])
    @endforeach
</form>
