@extends('belich::layout')

<table>
    <thead>
        <tr>
            @foreach($request['fields'] as $label => $attribute)
                <th>{{ $label }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($request['data'] as $data)
            <tr>
                @foreach($request['fields'] as $label => $attribute)
                    <td>{{ $data->{$attribute} }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
