{{-- Customize your breadcrumbs --}}
<nav class="w-full rounded-lg rounded-b-none shadow bg-white">
    <ul class="flex my-3 p-4 font-semibold">
        @foreach($request->breadcrumbs as $label => $url)
            {{-- Links --}}
            @if($label && $url)
                <li>
                    <a href="{{ $url }}" class="text-teal-600 font-medium underline">{{ $label }}</a>
                </li>

            {{-- Current --}}
            @else
                <li class="text-gray-600">{{ $label }}</li>
            @endif

            {{-- Set separator --}}
            @if(!$loop->last)
                <li class="mx-2">/</li>
            @endif
        @endforeach
    </ul>
</nav>
