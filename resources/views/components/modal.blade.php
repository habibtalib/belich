<div id="{{ $containerID }}" class="modal absolute pin-t pin-r pin-b pin-l invisible opacity-0">
    {{-- This link will close the modal when clicking outside --}}
    <a class="absolute w-full h-full cursor-default" href="#"></a>
    {{-- Load the modal container --}}
    <div class="relative w-1/3 mt-24 mx-auto shadow-md rounded bg-white border border-grey-light">
        {{-- Close icon --}}
        <div class="float-right m-2 p-1"><a href="#" class="close text-white font-bold text-lg">@icon('times')</a></div>
        {{-- Title --}}
        <h2 class="{{ 'bg-' . $background ?? 'bg-grey-dark'}} {{ 'text-' . $color ?? 'text-white'}} font-bold rounded-t p-4">{!! $title !!}</h2>
        {{-- Content --}}
        <p class="p-8 leading-loose">
            {!! $content !!}
        </p>
        {{-- Footer --}}
        @isset($footer)
            <div class="bg-grey-lighter text-white p-4 text-{{ $footerAlign ?? 'right' }}">
                {!! $footer !!}
            </div>
        @endisset
    </div>
</div>
