<div class="flex w-full justify-end bg-{{ $background ?? 'grey-lightest' }} border-b border-grey-lighter shadow-md p-4 px-6">
    <a
        href="{{ Belich::actionRoute($type, $id) }}"
        class="btn btn-{{ $color ?? 'secondary' }}">
            {!! $icon !!}
    </a>
</div>

{{--     {!! Tailblade::make('div')
        ->flex(8)
        ->width('full')
        ->background('red', 'light')
        ->margin('top', 5)
        ->radius('top', 10)
        ->padding('top', 2)
        ->addClass('dam1', 'dam2')
        ->hover('bg-teal', 'text-red')
        ->responsive('sm', 'hidden')
        ->create()
    !!}
       hellow world
    {!! Tailblade::close() !!} --}}
</div>
