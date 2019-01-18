@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.breadcrumbs')

    <form method="POST" name="form-{{ $resource['name'] }}-create" id="form-{{ $resource['name'] }}-create" action="{{ route(getRouteForm($resource['name'], 'store')) }}" class="form-container">
        @csrf

        @foreach($resource['fields'] as $field)
            @includeIf('belich::fields.' . $field->type, ['field' => $field])
        @endforeach

        <div class="btn-container">
            <button id="button-form-create" type="submit" class="btn btn-primary">@trans('buttons.crud.create')</button>
        </div>
    </form>
@endsection

{{-- Javascript from packages --}}
@section('javascript')
    {!! $javascript->get('javascript') !!}
@endsection
