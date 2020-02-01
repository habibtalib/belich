{{-- <li> --}}
    <div dusk="logout" class="flex items-center h-16 w-auto font-medium cursor-pointer {{ config('belich.navbar.display') === 'top' ? 'text-white' : 'text-gray-600' }}">
        @if(config('belich.profile'))
            <div class="pr-4">
                {{-- Gravatar --}}
                <img src="{!! Helper::gravatar(auth()->user()->email) !!}" class="block h-10 rounded-full shadow-md" alt="My gravatar">
                {{-- Profile image --}}
                {{-- <img src="{{ Storage::disk('public')->url(auth()->user()->profile->profile_avatar) }}" class="block h-10 rounded-full shadow-md" alt="My avatar"> --}}
            </div>
        @endif
        <div class="pr-1">
            {{-- Only for testing... --}}
            @if(App::environment('testing'))
                Testing User
            @else
                {{ auth()->user()->name }}
            @endif
        </div>
        <div class="pr-4">{!! Helper::icon('b-down', '', 'icon') !!}</div>
    </div>
    <ul class="right-0">
        @if(config('belich.profile'))
            <li class="bg-gray-200">
                <a href="{{ Belich::url() . '/profiles/' . auth()->user()->id }}" class="text-gray-600 hover:text-black" dusk="logout-profile">
                    {!! Helper::icon('b-user', 'Profile', 'icon') !!}
                </a>
            </li>
        @endif
        <li class="bg-gray-200">
            <a href="{{ route('logout') }}" class="text-gray-600 hover:text-black" onclick="event.preventDefault(); document.getElementById('dashboard-logout').submit();"  dusk="logout-session">
                {!! Helper::icon('b-close-circle', trans('belich::buttons.base.logout'), 'icon') !!}
            </a>
            <form id="dashboard-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
{{-- </li> --}}
