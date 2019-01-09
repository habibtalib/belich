@extends('belich::layout')

<form name="form-update" id="form-update" method="PATCH" action="">
    @csrf
    @foreach($request['fields'] as $value)
        @includeIf('belich::fields.' . $value->type, [
            'request' => $value,
            'data' => $request['data']
        ])
    @endforeach
</form>
