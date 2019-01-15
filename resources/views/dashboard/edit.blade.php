@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    <form name="form-{{ $request->get('resource') }}-edit" id="form-{{ $request->get('resource') }}-edit" method="POST" action="{{ route(getRouteForm($request->get('resource'), 'store')) }}">
        @csrf
        @method('PATCH')
        @foreach($request->get('fields') as $field)
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
