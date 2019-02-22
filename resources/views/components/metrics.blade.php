<div class="{{ $metric->width }} h-80 p-2 overflow-hidden shadow bg-white border border-grey-lighter">
    {{-- Legends --}}
    @hasMetricsLegends($metric)
        <div class="text-xs text-{{ setColor($metric, 'legend-color') }}-dark opacity-75 float-right border border-solid rounded-lg border-{{ setColor($metric, 'title-color') }}-lighter bg-{{ setColor($metric, 'title-color') }}-lightest mt-2 px-4 mr-5">
            <div class="p-1"><b class="mr-1">X:</b> {{ $metric->legend_h }}</div>
            <div class="p-1"><b class="mr-1">Y:</b> {{ $metric->legend_v }}</div>
        </div>
    @endif
    {{-- Header --}}
    <h4 class="text-{{ setColor($metric, 'title-color') }}-dark mt-2 px-4 ml-2">{{ $metric->name }}</h4>
    {{-- Graph --}}
    <div class="h-full py-4 pr-4">
        <div
            id="graph-{{ md5($metric->uriKey) }}"
            class="ct-chart {{ $metric->uriKey }} ct-perfect-fourth {{ ($metric->legend_h || $metric->legend_v) ? 'h-50 mt-3 z-10' : 'max-h-full' }} z-10">
        </div>
    </div>
</div>

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
