@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    <form name="form-edit" id="form-edit" method="POST" action="{{ route(getRouteForm($settings, 'update'), getRouteId()) }}">
        @csrf
        @method('PATCH')
        @foreach($request as $field)
            @includeIf('belich::fields.' . $field->type, ['field' => $field])
        @endforeach

        <div class="btn-container">
            <button id="button-form-update" type="submit" class="btn btn-primary">@trans('buttons.crud.update')</button>
        </div>
    </form>
@endsection

@section('javascript')

@endsection
