{{-- This section is segregate in case you want to customize --}}
<nav id="navbar" class="h-16 {{ config('belich.navbar') === 'top' ? 'bg-teal-light' : 'bg-white' }}">
    {{-- Top navbar --}}
    <ul>

        {{-- Logo --}}
        <li class="bg-teal-dark">
            <a class="text-white w-48" href="{{ Belich::url() }}">{{ Belich::name() }}</a>
        </li>

        {{-- Top navbar --}}
        @if(config('belich.navbar') === 'top')
            {{-- Get all the resources --}}
            @foreach(Belich::getGroupResources() as $resource)

                {{-- One level resource --}}
                @if($resource->count() <= 1)
                    <li class="hover:bg-teal">
                        <a class="text-white" href="{{ sprintf('%s/%s', Belich::url(), $resource->first()->get('resource')) }}">
                            {{ $resource->first()->get('name') }}
                        </a>
                    </li>

                {{-- two level resource --}}
                @else
                    <li class="hover:bg-teal">
                        <a class="text-white" href="{{ sprintf('%s/%s', Belich::url(), $resource->first()->get('resource')) }}">
                            {{ $resource->first()->get('group') }}
                            <i class="fas fa-caret-down ml-1 icon"></i>
                        </a>
                        <ul>
                            @foreach($resource as $item)
                                <li class="bg-teal-light hover:bg-teal-lighter">
                                    <a class="text-white hover:text-teal-dark" href="{{ sprintf('%s/%s', Belich::url(), $item->get('resource')) }}">
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

