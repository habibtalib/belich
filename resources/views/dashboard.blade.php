@extends('belich::layout')

@section('content')
    <div class="flex flex-wrap my-8 mx-6 p-4 rounded bg-white {{ config('belich.navbar') === 'top' ? 'shadow-md' : '' }}">

        {{-- Calendar --}}
        <belich::calendar id="tool-calendar" width="w-1/3"></belich::calendar>

        {{-- Model to table --}}
        <belich::model :columns="['id', 'name', 'email']" :model="app(\App\User::class)" id="tool-model" width="w-2/3" limit="5" ></belich::model>

    </div>
@endsection
