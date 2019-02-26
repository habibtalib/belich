@extends('belich::layout')

@section('content')
    <div class="shadow-md bg-white rounded my-8 mx-6 p-4">

        <a href="#modal-delete" class="button">Delete</a>

        @component('belich::components.modal')
            @slot('containerID', 'modal-delete')
            @slot('background', 'red')
            @slot('color', 'white')
            @slot('title', icon('trash', 'Delete fields'))
            @slot('content')
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            @endslot
            @slot('footer')
                <button class="btn btn-primary">Send</button>
            @endslot
        @endcomponent

        {!! Tailblade::make('div')
            ->attributes('id', 'en la casa')
            ->attributes('data-value', 'value1')
            ->size(8)
            ->color('red')
            ->background('red', 'light')
            ->margin('top', 5)
            ->radius('top', 10)
            ->padding('top', 2)
            ->addClass('dam1', 'dam2')
            ->hover('bg-teal', 'text-red')
            ->responsive('sm', 'hidden')
            ->create()
        !!}
           hellow world
        {!! Tailblade::close() !!}
    </div>
@endsection
