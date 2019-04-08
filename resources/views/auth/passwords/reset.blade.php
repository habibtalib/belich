@extends('belich::layout')

@section('content')
    <div class="container mx-auto h-full flex justify-center items-center">
        <div class="w-1/3 max-w-md">
            {{-- Title --}}
            <h1 class="text-2xl text-teal-700 mb-6 text-center">@lang('belich::authorization.reset.password')</h1>
            {{-- Container --}}
            <div class="p-8 bg-white mb-6 rounded-lg shadow-lg">
                {{-- Form --}}
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    {{-- Email --}}
                    <div class="mb-6">
                        <label class="font-bold text-grey-700 block mb-2">@lang('belich::authorization.login.email')</label>
                        <input type="text" name="email" class="block appearance-none w-full bg-white border border-grey-400 hover:border-grey-500 px-2 py-2 rounded shadow" value="{{ old('email') }}" placeholder="{{ trans('belich::authorization.placeholder.email') }}">
                        @if(isset($errors) && $errors->has('email'))
                            <span class="text-red text-xs italic" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    {{-- Password --}}
                    <div class="mb-6">
                        <label class="font-bold text-grey-700 block mb-2">@lang('belich::authorization.login.password')</label>
                        <input type="password" name="password" class="block appearance-none w-full bg-white border border-grey-400 hover:border-grey-500 px-2 py-2 rounded shadow" placeholder="{{ trans('belich::authorization.placeholder.password') }}">
                        @if(isset($errors) && $errors->has('password'))
                            <span class="text-red text-xs italic" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    {{-- Password confirm --}}
                    <div class="mb-6">
                        <label class="font-bold text-grey-700 block mb-2">@lang('belich::authorization.register.password_confirmation')</label>
                        <input type="password" name="password_confirmation" class="block appearance-none w-full bg-white border border-grey-400 hover:border-grey-500 px-2 py-2 rounded shadow" placeholder="{{ trans('belich::authorization.register.password_confirmation') }}">
                    </div>
                    {{-- Button --}}
                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-teal-600 hover:bg-teal-500 text-white font-bold py-2 px-4 rounded">
                            @lang('belich::authorization.reset.password')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
