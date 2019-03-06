{{-- This section is segregate in case you want to customize --}}
<nav id="sidebar" class="bg-grey-darker w-48">
    <ul class="text-lg">
        {{-- Get all the resources --}}
        @foreach(Belich::getGroupResources() as $resource)

            {{-- One level resource --}}
            @if($resource->count() <= 1)
                <li class="my-6 ml-6">
                    <a class="text-white font-medium" href="{{ sprintf('%s/%s', Belich::url(), $resource->first()->get('resource')) }}">
                        {!! icon($resource->first()->get('icon'), $resource->first()->get('name')) !!}
                    </a>
                </li>

            {{-- two level resource --}}
            @else
                <li class="my-6 ml-6">
                    <a class="text-white font-medium" href="{{ sprintf('%s/%s', Belich::url(), $resource->first()->get('resource')) }}">
                        {!! icon($resource->first()->get('icon'), $resource->first()->get('group')) !!}
                    </a>
                    <ul>
                        @foreach($resource as $item)
                            <li class="my-4 ml-6">
                                <a class="text-grey-lighter" href="{{ sprintf('%s/%s', Belich::url(), $item->get('resource')) }}">
                                    {{-- {!! icon($item->get('icon'), $item->get('name')) !!} --}}
                                    {!! icon('caret-right', $item->get('name')) !!}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif
        @endforeach
    </ul>
</nav>
