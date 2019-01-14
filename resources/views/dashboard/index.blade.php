@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    <form name="form-index" id="form-index" method="POST" action="">
        <table class="table">
            <thead>
                <tr>
                    @foreach(data_get($request, 'fields.labels') as $label)
                        <th>{{ $label }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse($request->get('sqlResponse') as $item)
                    <tr>
                        @foreach(data_get($request, 'fields.attributes') as $attribute)
                            <td>{{ optional($item)->{$attribute} ?? emptyResults() }}</td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ data_get($request, 'fields.labels')->count() }}" class="text-center">
                            No hay resultados...
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </form>
@endsection
