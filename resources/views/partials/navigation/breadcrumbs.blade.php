<nav class="w-full rounded-lg rounded-b-none shadow bg-white">
    <ul class="flex list-reset my-3 p-4 font-semibold">
        @foreach($request->breadcrumbs as $label => $url)
            @if($label && $url)
                <li>
                    <a href="{{ $url }}" class="text-teal-dark font-medium underline">{{ $label }}</a>
                </li>
            @else
                <li class="text-grey-darker">{{ $label }}</li>
            @endif

            {{-- Set separator --}}
            @if(!$loop->last)
                <li class="mx-2">/</li>
            @endif
        @endforeach
    </ul>
</nav>
