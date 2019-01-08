@extends('belich::layout')

<form class="form">
    @foreach($request['fields'] as $value)
        @includeIf('belich::fields.' . $value->type, ['request' => $value])
    @endforeach
</form>
