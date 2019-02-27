@isset($url)
    <a
        {{ isset($id) ? $id : ''}}
        href="{{ $url ?? '#' }}"
        class="btn btn-{{ $color ?? 'secondary' }} {{ $class ?? '' }}"
        {!! isset($loading) ? 'onclick="loading(this);"' : '' !!}
    >
        {!! $title !!}
    </a>
@else
    <button
        {{ isset($id) ? $id : ''}}
        type="{{ $type ?? 'submit' }}"
        class="btn btn-{{ $color ?? 'secondary' }} {{ $class ?? '' }}"
        {!! isset($loading) ? 'onclick="loading(this);"' : '' !!}
    >
        {!! $title !!}
    </button>
@endif
