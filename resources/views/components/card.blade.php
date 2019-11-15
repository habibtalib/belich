<div id="cards-{{ $card->uriKey }}" class="{{ $card->width }} p-8 overflow-hidden shadow bg-{{ $background ?? 'white' }} border border-gray-200">
    {{ $content }}
</div>
