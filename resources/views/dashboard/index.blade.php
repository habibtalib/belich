@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    <form name="form-index" id="form-index" method="POST" action="">
        <table class="table">
            <thead>
                <tr>
                    @foreach($request->get('labels') as $label)
                        <th>{{ $label }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($request->get('data') as $item)
                    <tr>
                        @foreach($request->get('attributes') as $attribute)
                            <td>{{ optional($item)->{$attribute} ?? emptyResults() }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>
@endsection
