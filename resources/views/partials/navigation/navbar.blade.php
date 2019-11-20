{{-- This section is segregate in case you want to customize --}}
{{-- Top navbar --}}
@if(config('belich.navbar.display') === 'top')
    <nav id="navbar" class="w-full h-16 bg-teal-400">
        {{-- Top navbar --}}
        <ul>
            {{-- Logo --}}
            <li class="bg-gray-600">
                <a class="text-white w-48" href="{{ Belich::url() }}" dusk="navbar-brand">{{ Belich::name() }}</a>
            </li>
            @if(config('belich.navbar.display') === 'top')
                {{-- Get all the resources --}}
                @foreach(Belich::groupResources() as $resource)
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
                                    <li class="bg-teal-600 hover:bg-teal-700">
                                        <a class="text-white" href="{{ sprintf('%s/%s', Belich::url(), $item->get('resource')) }}" dusk="navbar-{{ strtolower($item->get('name')) }}">
                                            {!! Helper::icon($item->get('icon'), $item->get('name')) !!}
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
{{-- Sidebar --}}
@else
    <nav id="navbar" class="w-full h-16 bg-gray-100 border-b border-gray-300">
        {{-- Top navbar --}}
        <ul>
            {{-- Logout --}}
            <li class="float-right">
                @include('belich::partials.navigation.logout')
            </li>
        </ul>
    </nav>
@endif
