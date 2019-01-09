@extends('belich::layout')

<form name="form-update" id="form-update" method="PATCH" action="">
    @csrf
    @foreach($request as $field)
        @includeIf('belich::fields.' . $field->type, ['field' => $field])
    @endforeach
</form>
