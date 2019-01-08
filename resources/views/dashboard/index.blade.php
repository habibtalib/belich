@extends('belich::layout')

@section('content')
    <table class="m-4 text-sm">
        <thead class="uppercase text-left text-grey-darker">
            <tr class="border-t border-b border-solid border-grey-light bg-grey-lighter">
                @foreach($request['fields'] as $label => $attribute)
                    <th class="py-4 px-6">{{ $label }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($request['data'] as $data)
                <tr>
                    @foreach($request['fields'] as $label => $attribute)
                        <td class="py-4 px-6 border-b border-solid border-grey-light">{{ $data->{$attribute} }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
