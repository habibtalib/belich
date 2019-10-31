{{-- This section is segregate in case you want to customize --}}
<nav id="navbar" class="w-full h-16 {{ config('belich.navbar') === 'top' ? 'bg-teal-400' : 'bg-white' }}">
    {{-- Top navbar --}}
    <ul>
        {{-- Logo --}}
        <li class="bg-teal-700">
            <a class="text-white w-48" href="{{ Belich::url() }}" dusk="navbar-brand">{{ Belich::name() }}</a>
        </li>

        {{-- Top navbar --}}
        @if(config('belich.navbar') === 'top')
            {{-- Get all the resources --}}
            @foreach(Belich::getGroupResources() as $resource)
                {{-- One level resource --}}
                @if($resource->count() <= 1)
                    <li class="hover:bg-teal-600">
                        <a class="text-white" href="{{ sprintf('%s/%s', Belich::url(), $resource->first()->get('resource')) }}" dusk="navbar-{{ strtolower($resource->first()->get('name')) }}">
                            {{ $resource->first()->get('name') }}
                        </a>
                    </li>

                {{-- two level resource --}}
                @else
                    <li class="hover:bg-teal-600">
                        <a class="text-white" href="{{ sprintf('%s/%s', Belich::url(), $resource->first()->get('resource')) }}" dusk="navbar-{{ strtolower($resource->first()->get('group')) }}">
                            {{ $resource->first()->get('group') }}
                            <i class="fas fa-caret-down ml-1 icon"></i>
                        </a>
                        <ul>
                            @foreach($resource as $item)
                                <li class="bg-teal-400 hover:bg-teal-200">
                                    <a class="text-white hover:text-teal-600" href="{{ sprintf('%s/%s', Belich::url(), $item->get('resource')) }}" dusk="navbar-{{ strtolower($item->get('name')) }}">
                                        {{ $item->get('name') }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endforeach
        @endif

        {{-- Logout --}}
        <li class="float-right">
            @include('belich::partials.navigation.logout')
        </li>
    </ul>
</nav>

