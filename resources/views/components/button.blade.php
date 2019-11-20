@isset($url)
    <a
        {!! isset($id) ? 'id="' . $id . '"' : '' !!}
        href="{{ $url ?? '#' }}"
        @isset($dusk)
            dusk="{{ $dusk }}"
        @endif
        class="btn btn-{{ $color ?? 'secondary' }} {{ $class ?? '' }} ml-2 rounded-lg hover:bg-gray-100 hover:text-gray-800"
        data-title="{{ $title }}"
        {!! isset($loading) ? 'onclick="loading(this);"' : '' !!}
        {!! isset($onclick) ? 'onclick="' . $onclick . '"' : '' !!}
    >
        {!! $title !!}
    </a>
@else
    <button
        {!! isset($id) ? 'id="' . $id . '"' : '' !!}
        type="{{ $type ?? 'button' }}"
        @isset($dusk)
            dusk="{{ $dusk }}"
        @endif
        class="btn btn-{{ $color ?? 'secondary' }} mx-2 {{ $class ?? '' }} ml-4"
        data-title="{{ $title }}"
        {!! isset($loading) ? 'onclick="loading(this);"' : '' !!}
        {!! isset($onclick) ? 'onclick="' . $onclick . '"' : '' !!}
    >
        {!! $title !!}
    </button>
@endif
