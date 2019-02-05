@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.breadcrumbs')

    <form method="POST" name="form-{{ $resource }}-create" id="form-{{ $resource }}-create" action="{{ Utils::formRedirectTo('store') }}" class="form-container">
        @csrf

        {{-- Include the fields by type --}}
        @foreach($fields as $field)
            @includeIf('belich::fields.' . $field->type, ['field' => $field])
        @endforeach

        {{-- Buttons --}}
        <div class="btn-container">
            <button id="button-form-create" type="submit" class="btn btn-primary">{!! Utils::icon('plus-square', trans('belich::buttons.crud.create')) !!}</button>
        </div>
    </form>
@endsection

{{-- Javascript from packages --}}
@section('javascript')
    {!! $javascript->get('javascript') !!}
@endsection
