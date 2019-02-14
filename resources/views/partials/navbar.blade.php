{{-- This section is segregate in case you want to customize --}}
<nav id="navbar" class="h-12 bg-teal">
    {!!
        Belich::navbar()
            ->setBrandName('hellow')
            ->get();
    !!}
</nav>

