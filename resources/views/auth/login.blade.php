@extends('belich::layout')

@section('content')
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="container mx-auto h-full flex justify-center items-center">
            <div class="w-1/3">
                <h1 class="font-hairline mb-6 text-center">Login to Belich</h1>
                <div class="border-teal p-8 border-t-12 bg-white mb-6 rounded-lg shadow-lg">
                    <div class="mb-4">
                        <label class="font-bold text-grey-darker block mb-2">Email</label>
                        <input type="text" name="email" class="block appearance-none w-full bg-white border border-grey-light hover:border-grey px-2 py-2 rounded shadow" placeholder="Your email">
                        @if(isset($errors) && $errors->has('email'))
                            <span class="text-red text-xs italic" for="email">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label class="font-bold text-grey-darker block mb-2">Password</label>
                        <input type="password" name="password" class="block appearance-none w-full bg-white border border-grey-light hover:border-grey px-2 py-2 rounded shadow" placeholder="Your Password">
                        @if(isset($errors) && $errors->has('password'))
                            <span class="text-red text-xs italic" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-teal-dark hover:bg-teal text-white font-bold py-2 px-4 rounded">
                            Login
                        </button>
                        <a class="no-underline inline-block align-baseline font-bold text-sm text-blue hover:text-blue-dark float-right" href="#">
                            Forgot Password?
                        </a>
                    </div>

                </div>
                <div class="text-center">
                    <p class="text-grey-dark text-sm">Don't have an account? <a href="#" class="no-underline text-blue font-bold">Create an Account</a>.</p>
                </div>
            </div>
        </div>
    </form>
@endsection
