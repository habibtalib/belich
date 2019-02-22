@component('belich::components.card')
    @slot('header', $metric->name)
    @slot('width', $metric->width ?? 'w-1/3')
    @slot('content')

        {{-- Legends --}}
        @if($metric->legend_h || $metric->legend_v)
            <div class="text-xs text-{{ $metric->color }}-dark opacity-75 float-right border border-solid rounded-lg border-{{ $metric->color }}-lighter bg-{{ $metric->color }}-lightest p-1 px-2 mr-3 z-10" style="margin-top: -44px">
                <div class="p-1"><b class="mr-1">X:</b> {{ $metric->legend_h }}</div>
                <div class="p-1"><b class="mr-1">Y:</b> {{ $metric->legend_v }}</div>
            </div>
        @endif

        {{-- Graph --}}
        <div id="graph-{{ md5($metric->uriKey) }}" class="ct-chart {{ $metric->uriKey }} ct-perfect-fourth max-h-full"></div>
    @endslot
@endcomponent

@prepend('javascript-metrics')
    {!!
        Metric::uriKey('hellow')
            ->uriKey($metric->uriKey)
            ->labels($metric->labels)
            ->series([$metric->calculate])
            ->type($metric->type)
            ->withArea($metric->withArea)
            ->get()
    !!}
@endprepend

@prepend('css-metrics')
    {{-- Load the custom css styles for the lib --}}
    {!! Metric::css($metric) !!}
@endprepend
