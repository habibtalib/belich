@extends('belich::layout')

<form name="form-create" id="form-create" method="POST" action="">
    @csrf
    @foreach($request['fields'] as $value)
        @includeIf('belich::fields.' . $value->type, ['request' => $value])
    @endforeach
</form>
