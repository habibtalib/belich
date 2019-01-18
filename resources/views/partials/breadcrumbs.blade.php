<nav class="nav-breadcrumbs">
    <ul>
        @foreach($resource['breadcrumbs'] as $title => $url)
            @if(empty($url))
                <li>{{ $title }}</li>
            @else
                <li><a href="{{ $url }}" class="text-blue font-bold">{{ $title }}</a></li>
            @endif
            @if(!$loop->last)
                <li class="separator">/</li>
            @endif
        @endforeach
    </ul>
</nav>
