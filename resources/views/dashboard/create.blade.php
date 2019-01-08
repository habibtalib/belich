@extends('belich::layout')

<form class="w-full max-w-xs">
    @foreach($request['fields'] as $value)
        @includeIf('belich::fields.' . $value->type, ['request' => $value])
    @endforeach
</form>
