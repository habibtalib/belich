{{-- Customize your breadcrumbs --}}
<nav class="w-full bg-white">
    <ul class="flex p-4 border-b border-gray-300 font-semibold">
        @foreach($request->breadcrumbs as $label => $url)
            {{-- Links --}}
            @if($label && $url)
                <li>
                    <a href="{{ $url }}" class="{{ ($loop->first) ? 'ml-2' : ''}} text-teal-600 font-medium underline" dusk="breadcrumbs-{{ strtolower($label) }}">{{ $label }}</a>
                </li>

            {{-- Current --}}
            @else
                <li class="text-gray-600" dusk="breadcrumbs-{{ strtolower($label) }}">{{ $label }}</li>
            @endif

            {{-- Set separator --}}
            @if(!$loop->last)
                <li class="mx-2">/</li>
            @endif
        @endforeach
    </ul>
</nav>
