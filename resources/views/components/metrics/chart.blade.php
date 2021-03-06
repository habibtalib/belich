<div id="metrics-{{ $metric->uriKey }}" dusk="metrics-{{ $metric->uriKey }}" class="{{ $metric->width ?? 'w-1/3' }} h-80 p-2 overflow-hidden bg-white border border-gray-200">
    {{-- Legends --}}
    @includeWhen(Helper::hasMetricsLegends($metric), 'belich::components.metrics.legend')

    {{-- Header --}}
    <h4 dusk="metrics-header-{{ $metric->uriKey }}" class="text-{{ Helper::metricsColor($metric, 'title-color') }}-600 mt-2 px-4 ml-2">{{ $metric->name }}</h4>

    {{-- Graph --}}
    <div class="h-full py-4 pr-4">
        <div
            id="graph-{{ $metric->type }}-{{ md5($metric->uriKey) }}"
            dusk="metrics-graph-{{ $metric->uriKey }}"
            class="ct-chart {{ $metric->uriKey }} ct-perfect-fourth {{ ($metric->legend_h || $metric->legend_v) ? 'h-50 mt-3 z-10' : 'max-h-full' }} z-10">
        </div>
    </div>
</div>

@prepend('javascript-metrics')
    {!!
        Chart::uriKey($metric->uriKey)
            ->labels($metric->labels)
            //Pie charts has not support for multidimensional arrays
            ->series(($metric->type === 'pie') ? $metric->calculate : [$metric->calculate])
            ->type($metric->type)
            ->withArea($metric->withArea)
            ->get()
    !!}
@endprepend

@push('css-metrics')
    <style>
        {{-- Load the custom css styles for the lib --}}
        {!! Chart::css($metric) !!}
    </style>
@endpush
