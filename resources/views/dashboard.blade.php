@extends('belich::layout')

@section('content')
    <div class="flex flex-wrap my-8 mx-6 p-4 rounded bg-white {{ config('belich.navbar') === 'top' ? 'shadow-md' : '' }}">

        {{-- Calendar --}}
        <belich::calendar id="tool-calendar" width="w-1/3"></belich::calendar>

        {{-- Model to table --}}
        <belich::model id="tool-model" :columns="['id', 'name', 'email']" model="\App\User" width="w-2/3" limit="5" ></belich::model>

    </div>
@endsection
