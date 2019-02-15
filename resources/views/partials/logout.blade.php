{{-- <li> --}}
    <a href="#" class="text-grey-darker">@icon('cog', 'Settings')</a>
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
