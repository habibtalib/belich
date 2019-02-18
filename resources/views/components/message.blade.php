<div class="bg-{{ $message_color }}-lightest shadow-md rounded-lg opacity-75 pt-4 pl-6 pr-8 pb-6 relative w-1/3" role="alert">
    <p class="text-lg text-{{ $message_color }}-darker border-b border-{{ $message_color }}-lighter capitalize font-bold mb-3 pb-2">{!! icon($message_icon, $message_header) !!}</p>
    @foreach($message_bag as $message)
        <li class="mb-2 text-black">{{ $message }}</li>
    @endforeach
    <span class="absolute pin-t pin-b pin-r px-4 py-3 cursor-pointer">
        @icon('times')
    </span>
</div>
