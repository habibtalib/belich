<div id="menssage-alert" class="relative rounded-lg pt-4 pl-6 pr-8 pb-6 w-1/3 bg-{{ $color }}-lightest shadow-md fade-out" role="alert">
    {{-- Header --}}
    <p class="text-lg text-{{ $color }}-darker border-b border-{{ $color }}-lighter capitalize font-bold mb-3 pb-2">
        {{-- Session header or custom --}}
        {!! icon($icon, session()->get('header') ?? $header) !!}
    </p>

    {{-- Messages --}}
    {{-- App\Http\Helpsers\Messages --}}
    @foreach(messages($type) as $message)
        <li class="mb-2 text-black">{{ $message }}</li>
    @endforeach

    {{-- Close alert --}}
    <a href="#" class="absolute pin-t pin-b pin-r px-4 py-3 cursor-pointer text-black" onclick="closeMenssage();">
        @icon('times')
    </a>
</div>

@prepend('javascript')
    <script>
        //Close alert with fadeOut
        function closeMenssage(container) {
            //Set container
            var container = document.getElementById('menssage-alert');
            //Set the opacity to 0
            container.style.opacity = '0';
            //Hide the div after 500ms
            setTimeout(function() {container.style.display = 'none';}, 500);
        }
    </script>
@endprepend
