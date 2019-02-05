{!! Belich::breadcrumbs($breadcrumbs) !!}
{{--
<nav class="nav-breadcrumbs">
    <ul class="nav-breadcrumbs-list">
        @foreach($resource['breadcrumbs'] as $key => $value)
            @if(empty($value['url']))
                <li class="nav-breadcrumbs-items-current">{{ $value['title'] }}</li>
            @else
                <li class="nav-breadcrumbs-items">
                    <a href="{{ $value['url'] }}" class="text-blue font-bold">
                        {{ $value['title'] }}
                    </a>
                </li>
            @endif
            @if(!$loop->last)
                <li class="separator"></li>
            @endif
        @endforeach
    </ul>
</nav>
--}}
