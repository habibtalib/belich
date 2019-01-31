@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.breadcrumbs')

    {{-- Table --}}
    <form name="form-index" id="form-index" method="POST" action="">
        <table class="table">
            <thead>
                <tr>
                    @foreach($resource['fields'] as $field)
                        <th>
                            {!! urlBuilderForTableHead($field) !!}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse($resource['results'] as $item)
                    <tr>
                        @foreach($resource['fields'] as $field)
                            <td>{{ evalue($item, $field->attribute) }}</td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ countResults($resource['fields']['labels']) }}" class="text-center">
                            {{ trans('belich::messages.resources.no_results') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
            @if($pagination = $resource['results']->links())
                <tfoot>
                    <tr>
                        <td colspan="{{ countResults($resource['fields']) }}" class="text-center">{{ $pagination }}</td>
                    </tr>
                </tfoot>
            @endif
        </table>
    </form>
@endsection
