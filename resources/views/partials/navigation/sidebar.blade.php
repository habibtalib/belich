{{-- This section is segregate in case you want to customize --}}
<nav id="sidebar" class="h-full bg-teal-500 pb-4">
    <ul class="text-base">
        {{-- Logo --}}
        <li class="h-16 p-5 mb-4 bg-teal-800 text-center mb-2">
            <a class="text-white text-lg font-bold" href="{{ Belich::url() }}" dusk="navbar-brand">{{ Belich::name() }}</a>
        </li>
        {{-- Get all the resources --}}
        @foreach(Belich::groupResources() as $resource)

            {{-- One level resource --}}
            @if($resource->count() <= 1)
                <li class="px-4 mb-4">
                    <a class="text-white font-medium" href="{{ sprintf('%s/%s', Belich::url(), $resource->first()->get('resource')) }}">
                        {!! Helper::icon($resource->first()->get('icon'), $resource->first()->get('name')) !!}
                    </a>
                </li>

            {{-- two level resource --}}
            @else
                <li class="pl-2 py-3">
                    <a class="text-white font-medium" href="{{ sprintf('%s/%s', Belich::url(), $resource->first()->get('resource')) }}">
                        {!! Helper::icon($resource->first()->get('icon'), $resource->first()->get('group')) !!}
                    </a>
                    <ul>
                        @foreach($resource as $item)
                            <li class="my-4 ml-6">
                                <a class="text-gray-200" href="{{ sprintf('%s/%s', Belich::url(), $item->get('resource')) }}">
                                    {{-- {!! icon($item->get('icon'), $item->get('name')) !!} --}}
                                    {!! Helper::icon('b-right', $item->get('name')) !!}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif
        @endforeach
    </ul>
</nav>
