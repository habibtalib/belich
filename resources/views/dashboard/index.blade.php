@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::dashboard.components.breadcrumbs')

    {{-- Table --}}
    <form name="form-index" id="form-index" method="POST" action="">
        <table class="table">
            <thead>
                <tr>
                    @foreach($request->getValue('fields.labels') as $label)
                        <th>{{ $label }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse($request->get('sqlResponse') as $item)
                    <tr>
                        @foreach($request->getValue('fields.attributes') as $attribute)
                            <td>{{ evalue($item, $attribute) }}</td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $request->getValue('fields.labels')->count() }}" class="text-center">
                            {{ trans('belich::resources.no_results') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </form>
@endsection
