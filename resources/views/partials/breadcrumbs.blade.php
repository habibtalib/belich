<nav class="nav-breadcrumbs">
    <ul>
        @foreach($resource['breadcrumbs'] as $key => $value)
            @if(empty($value['url']))
                <li>{{ $value['title'] }}</li>
            @else
                <li><a href="{{ $value['url'] }}" class="text-blue font-bold">{{ $value['title'] }}</a></li>
            @endif
            @if(!$loop->last)
                <li class="separator">/</li>
            @endif
        @endforeach
    </ul>
</nav>
