@component('belich::components.card')
    @slot('header', $metric->name)
    @slot('width', $metric->width ?? 'w-1/3')
    @slot('content')
        <div id="graph-{{ md5($metric->uriKey) }}" class="ct-chart {{ $metric->uriKey }} ct-perfect-fourth max-h-full"></div>
    @endslot
@endcomponent

@prepend('javascript-metrics')
    {!!
        Metric::uriKey('hellow')
            ->uriKey($metric->uriKey)
            ->labels($metric->labels)
            ->serie([
                rand(0, 20),
                rand(0, 20),
                rand(0, 20),
                rand(0, 20),
                rand(0, 20),
                rand(0, 20),
                rand(0, 20)
            ])
            ->get()
    !!}
@endprepend

@prepend('css-metrics')
    {{-- Load the custom css styles for the lib --}}
    {!! Metric::css($metric) !!}
@endprepend
