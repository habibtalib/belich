<div id="menssage-alert" class="flex w-1/3 bg-{{ $color }}-100 p-4 shadow fade-out" role="alert">
    <div class="mr-4">
        <div class="flex justify-center items-center w-16 h-16 rounded-full bg-{{ $color }}-600 text-white">
            <i class="fas fa-{!! $icon !!} fa-lg"></i>
        </div>
    </div>
    <div class="flex justify-between w-full">
        <div class="text-{{ $color }}-600">
            {{-- Header --}}
            <p class="mb-2 text-lg font-bold">
                {{ $title }}
            </p>
            {{-- Messages --}}
            {{-- App\Http\Helpsers\Messages --}}
            @foreach(messages($type) as $message)
                <p class="text-md">{{ $message }}</p>
            @endforeach
        </div>
        <div class="text-md text-{{ $color }}-600 font-bold">
            <a href="#" onclick="closeMenssage();">{!! icon('times') !!}</a>
        </div>
    </div>
</div>
