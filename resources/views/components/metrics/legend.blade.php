{{-- Legends --}}
@hasMetricsLegends($metric)
    <div class="text-xs text-{{ Helper::metricsColor($metric, 'legend-color') }}-600 opacity-75 float-right border border-solid rounded-lg border-{{ Helper::metricsColor($metric, 'title-color') }}-200 bg-{{ Helper::metricsColor($metric, 'title-color') }}-100 mt-2 px-4 mr-5">
        <div class="p-1"><b class="mr-1">X:</b> {{ $metric->legend_h }}</div>
        <div class="p-1"><b class="mr-1">Y:</b> {{ $metric->legend_v }}</div>
    </div>
@endif
