{{-- <li> --}}
    <div class="flex items-center h-16 w-auto font-medium {{ config('belich.navbar') === 'top' ? 'text-white' : 'text-grey-darker' }}">
        <div class="pr-4"><img class="block h-10 rounded-full shadow" src="{{ gravatar(auth()->user()->email) }}" alt=""></div>
        <div class="pr-1">{{ auth()->user()->name }}</div>
        <div class="pr-4">@icon('angle-down')</div>
    </div>
    <ul class="pin-r">
        <li class="bg-grey-lighter">
            <a href="#" class="text-grey-darker hover:text-black">
                @icon('user', 'Profile')
            </a>
        </li>
        <li class="bg-grey-lighter">
            <a href="{{ route('logout') }}" class="text-grey-darker hover:text-black" onclick="event.preventDefault(); document.getElementById('dashboard-logout').submit();">
                @icon('times-circle', 'belich::buttons.base.logout')
            </a>
            <form id="dashboard-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
{{-- </li> --}}
