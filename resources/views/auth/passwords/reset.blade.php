@extends('belich::layout')

@section('content')
    <div class="container mx-auto h-full flex justify-center items-center">
        <div class="w-1/3 max-w-md">
            {{-- Title --}}
            <h1 class="font-normal mb-6 text-center">@lang('belich::authorization.reset.password')</h1>
            {{-- Container --}}
            <div class="border-teal p-8 border-t-12 bg-white mb-6 rounded-lg shadow-lg">
                {{-- Form --}}
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    {{-- Email --}}
                    <div class="mb-6">
                        <label class="font-bold text-grey-darker block mb-2">@lang('belich::authorization.login.email')</label>
                        <input type="text" name="email" class="block appearance-none w-full bg-white border border-grey-light hover:border-grey px-2 py-2 rounded shadow" value="{{ old('email') }}" placeholder="{{ trans('belich::authorization.placeholder.email') }}">
                        @if(isset($errors) && $errors->has('email'))
                            <span class="text-red text-xs italic" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    {{-- Password --}}
                    <div class="mb-6">
                        <label class="font-bold text-grey-darker block mb-2">@lang('belich::authorization.login.password')</label>
                        <input type="password" name="password" class="block appearance-none w-full bg-white border border-grey-light hover:border-grey px-2 py-2 rounded shadow" placeholder="{{ trans('belich::authorization.placeholder.password') }}">
                        @if(isset($errors) && $errors->has('password'))
                            <span class="text-red text-xs italic" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    {{-- Password confirm --}}
                    <div class="mb-6">
                        <label class="font-bold text-grey-darker block mb-2">@lang('belich::authorization.register.password_confirmation')</label>
                        <input type="password" name="password_confirmation" class="block appearance-none w-full bg-white border border-grey-light hover:border-grey px-2 py-2 rounded shadow" placeholder="{{ trans('belich::authorization.register.password_confirmation') }}">
                    </div>
                    {{-- Button --}}
                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-teal-dark hover:bg-teal text-white font-bold py-2 px-4 rounded">
                            @lang('belich::authorization.reset.password')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection