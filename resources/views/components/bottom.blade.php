{{-- Rounded container (bottom) --}}
<div class="flex flex-row-reverse content-center bg-blue-lightest h-18 shadow-md rounded-b-lg p-4">
    @isset($button)
        <div class="flex">
            {{ $button }}
        </div>
    @endif
</div>
