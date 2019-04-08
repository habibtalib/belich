@extends('belich::layout')

@section('content')
    <div class="container mx-auto h-full flex justify-center items-center">
        <div class="w-1/3 max-w-md">
            {{-- Title --}}
            <h1 class="text-2xl text-teal-700 font-semibold mb-6 text-center">@lang('belich::authorization.verify.email')</h1>
            {{-- Container --}}
            <div class="p-8 bg-white mb-6 rounded-lg shadow-lg">
                {{-- Alert --}}
                @if (session('resent'))
                    <div class="text-red-500 text-xs italic" role="alert">
                        @lang('belich::authorization.verify.refresh')
                    </div>
                @endif
                @lang('belich::authorization.verify.check')
                @lang('belich::authorization.verify.fail'), <a href="{{ route('verification.resend') }}">@lang('belich::authorization.verify.resend')</a>.
            </div>
        </div>
    </div>
@endsection
