<div class="flex w-full justify-end bg-{{ $background ?? 'grey-lightest' }} border-b border-grey-lighter shadow-md p-4 px-6">
    <a href="{{ Belich::actionRoute($type, $id) }}" class="btn btn-{{ $color ?? 'secondary' }}">
        {!! $icon !!}
    </a>
</div>
