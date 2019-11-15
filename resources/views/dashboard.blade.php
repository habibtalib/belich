@extends('belich::layout')

@section('content')
    <div class="{{ config('belich.navbar') === 'top' ? 'shadow-md' : '' }} bg-white rounded my-8 mx-6 p-4">

        {{-- Calendar --}}
        @include('belich::components.tools.calendar')

    </div>
@endsection
