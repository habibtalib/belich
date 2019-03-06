{{-- This section is segregate in case you want to customize --}}
<nav id="navbar" class="h-16 {{ config('belich.navbar') === 'top' ? 'bg-teal-light' : 'bg-white' }}">
    {{-- Top navbar --}}
    <ul class="bg-teal-light p-0 m-0 list-reset shadow z-10">

        {{-- Logo --}}
        <li class="bg-teal-dark inline-block">
            <a class="text-white w-48" href="{{ Belich::url() }}">{{ Belich::name() }}</a>
        </li>

        {{-- Top navbar --}}
        @if(config('belich.navbar') === 'top')
            {{-- Get all the resources --}}
            @foreach($resources as $resource)

                {{-- One level resource --}}
                @if($resource->count() <= 1)
                    <li class="inline-block">
                        <a class="text-white" href="{{ sprintf('%s/%s', Belich::url(), $resource->first()->get('resource')) }}">
                            {{ $resource->first()->get('name') }}
                        </a>
                    </li>

                {{-- two level resource --}}
                @else
                    <li>
                        <a class="text-white" href="{{ sprintf('%s/%s', Belich::url(), $resource->first()->get('resource')) }}">
                            {{ $resource->first()->get('group') }}
                            <i class="fas fa-caret-down ml-1 icon"></i>
                        </a>
                        <ul class="z-10 absolute invisible opacity-0 bg-teal-light hover:visible hover:z-40 hover:opacity-100">
                            @foreach($resource as $item)
                                <li>
                                    <a class="text-white" href="{{ sprintf('%s/%s', Belich::url(), $item->get('resource')) }}">
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
        <li class="inline-block float-right">
            @include('belich::partials.navigation.logout')
        </li>
    </ul>

</nav>

