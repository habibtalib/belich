{{-- Conditional form --}}
@if(!empty($form))
    <form method="POST" id="form-{{ \Illuminate\Support\Str::kebab($containerID) }}" name="form-{{ \Illuminate\Support\Str::kebab($containerID) }}" acction="{{ route('dashboard.' . $request->name . '.delete.selected') }}">
        @csrf
        <input type="hidden" id="delete_selected" name="delete_selected" value="">
@endif

    <div id="modal-{{ $containerID }}" class="modal absolute pin-t pin-r pin-b pin-l invisible opacity-0">
        {{-- This link will close the modal when clicking outside --}}
        <a class="absolute w-full h-full cursor-default" href="#"></a>
        {{-- Load the modal container --}}
        <div class="relative w-1/3 mt-24 mx-auto shadow-md rounded bg-white border border-grey-light">
            {{-- Close icon --}}
            <div class="float-right m-2 p-1"><a href="#" class="close text-white font-bold text-lg">@icon('times')</a></div>
            {{-- Title --}}
            <h2 class="{{ 'bg-' . $background ?? 'bg-grey-dark'}} {{ 'text-' . $color ?? 'text-white'}} font-bold rounded-t p-4">{!! $title !!}</h2>
            {{-- Content --}}
            <div class="p-8 leading-loose text-lg text-grey-darker">
                {!! $content !!}
            </div>
            {{-- Footer --}}
            @isset($footer)
                <div class="bg-grey-lighter text-white p-4 text-{{ $footerAlign ?? 'right' }}">
                    {!! $footer !!}
                </div>
            @endisset
        </div>
    </div>

{{-- Conditional form --}}
@if(!empty($form))
    </form>
@endif
