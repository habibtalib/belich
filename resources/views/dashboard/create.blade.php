@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    <form name="form-{{ $settings['resource'] }}-create" id="form-{{ $settings['resource'] }}-create" method="POST" action="{{ route(getRouteForm($settings, 'store')) }}">
        @csrf
        @foreach($request as $field)
            @includeIf('belich::fields.' . $field->type, ['field' => $field])
        @endforeach

        <div class="btn-container">
            <button id="button-form-create" type="submit" class="btn btn-primary">@trans('buttons.crud.create')</button>
        </div>
    </form>
@endsection

{{-- Javascript user custom configuration --}}
@include('belich::dashboard.components.form-javascript-settings')

{{-- Javascript from packages --}}
@section('javascript')
    {!! $javascript->get('javascript') !!}
@endsection
