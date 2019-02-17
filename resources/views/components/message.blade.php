<div class="bg-{{ $color }}-lightest text-{{ $color }}-darker shadow-md rounded-lg p-4 relative w-1/3" role="alert">
    <ul>
        @foreach($messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
    <span class="absolute pin-t pin-b pin-r px-4 py-3 cursor-pointer">
        @icon('times')
    </span>
</div>
