{{-- <li> --}}
    <div dusk="logout" class="flex items-center h-16 w-auto font-medium cursor-pointer {{ config('belich.navbar') === 'top' ? 'text-white' : 'text-gray-600' }}">
        @if(config('belich.profile'))
            <div class="pr-4">@gravatar()</div>
        @endif
        <div class="pr-1">{{ auth()->user()->name }}</div>
        <div class="pr-4">@icon('angle-down')</div>
    </div>
    <ul class="right-0">
        @if(config('belich.profile'))
            <li class="bg-gray-200">
                <a href="{{ Belich::url() . '/profiles/' . auth()->user()->id }}" class="text-gray-600 hover:text-black" dusk="logout-profile">
                    @icon('user', 'Profile')
                </a>
            </li>
        @endif
        <li class="bg-gray-200">
            <a href="{{ route('logout') }}" class="text-gray-600 hover:text-black" onclick="event.preventDefault(); document.getElementById('dashboard-logout').submit();"  dusk="logout-session">
                @icon('times-circle', 'belich::buttons.base.logout')
            </a>
            <form id="dashboard-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
{{-- </li> --}}
