@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.breadcrumbs')

    <form method="POST" name="form-{{ $request->name }}-edit" id="form-{{ $request->name }}-edit" action="{{ Belich::blade()->toRoute('update') }}" class="form-container">
        @csrf
        @method('PATCH')

        {{-- Include the fields by type --}}
        @foreach($request->fields as $field)
            @includeIf('belich::fields.' . $field->type, ['field' => $field])
        @endforeach

        {{-- Buttons --}}
        <div class="btn-container">
            <button id="button-form-edit" type="submit" class="btn btn-primary">@icon('pen-square', 'belich::buttons.crud.update')</button>
        </div>
    </form>
@endsection

{{-- Javascript from packages --}}
@section('javascript')
    {!! $request->javascript !!}
@endsection
