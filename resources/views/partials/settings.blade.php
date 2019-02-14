{{-- <li> --}}
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('dashboard-logout').submit();">
        @lang('belich::buttons.base.logout')
    </a>
    <form id="dashboard-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
{{-- </li> --}}
