<div class="{{ $width ?? 'w-full' }} metrics p-2 overflow-hidden shadow bg-white border border-grey-lighter">
    <h4 class="text-grey-darker mt-2 px-4 ml-2">{{ $header ?? 'Testing' }}</h4>
    <div class="h-full py-4 pr-4">
        {{ $content ?? null }}
    </div>
</div>
