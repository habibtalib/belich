@extends('belich::layout')

@section('content')
    <div class="shadow-md bg-white rounded my-8 mx-6 p-4">

        <a href="#modal1" class="button">Open Modal</a>

        <div id="modal1" class="modal absolute pin-t pin-r pin-b pin-l invisible opacity-0">
            {{-- This link will close the modal when clicking outside --}}
            <a class="absolute w-full h-full cursor-default" href="#"></a>
            {{-- Load the modal container --}}
            <div class="relative w-1/3 mt-20 mx-auto p-8 shadow-md rounded bg-white">
                Modal
            </div>
        </div>
    </div>
@endsection
