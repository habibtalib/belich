@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.breadcrumbs')

    <form method="POST" name="form-{{ $resource['name'] }}-edit" id="form-{{ $resource['name'] }}-edit" action="{{ routeForm($resource['name'], 'store') }}" class="form-container">
        @csrf
        @method('PATCH')

        @foreach($resource['fields'] as $field)
            @includeIf('belich::fields.' . $field->type, ['field' => $field])
        @endforeach

        <div class="btn-container">
            <button id="button-form-edit" type="submit" class="btn btn-primary">@trans('buttons.crud.update')</button>
        </div>
    </form>
@endsection

{{-- Javascript from packages --}}
@section('javascript')
    {!! $javascript->get('javascript') !!}
@endsection
