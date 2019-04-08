@extends('belich::layout')

@section('content')
    <div class="container mx-auto h-full flex justify-center items-center">
        <div class="w-1/3 max-w-md">
            {{-- Title --}}
            <h1 class="text-2xl text-teal-700 font-semibold mb-6 text-center">@lang('belich::authorization.forgot.reset')</h1>
            {{-- Container --}}
            <div class="p-8 bg-white mb-6 rounded-lg shadow-lg">
                {{-- Alert --}}
                @if (session('status'))
                    <div class="text-red-500 text-xs italic" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                {{-- Form --}}
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    {{-- Email --}}
                    <div class="mb-6">
                        <label class="font-bold text-grey-600 block mb-2">@lang('belich::authorization.login.email')</label>
                        <input type="text" name="email" class="block appearance-none w-full bg-white border border-grey-400 hover:border-grey-500 px-2 py-2 rounded shadow" placeholder="{{ trans('belich::authorization.placeholder.email') }}" autofocus>
                        @if(isset($errors) && $errors->has('email'))
                            <span class="text-red-500 text-xs italic" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    {{-- Button --}}
                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-teal-600 hover:bg-teal-500 text-white font-bold py-2 px-4 rounded">
                            @lang('belich::authorization.buttons.reset')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
