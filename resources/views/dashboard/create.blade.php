@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.breadcrumbs')

    <form method="POST" name="form-{{ $request->name }}-create" id="form-{{ $request->name }}-create" action="{{ toRoute('store') }}" class="form-container">
        @csrf

        {{-- Include the fields by type --}}
        @foreach($request->fields as $field)
            @includeIf('belich::fields.' . $field->type, ['field' => $field])
        @endforeach

        {{-- Buttons --}}
        <div class="btn-container">
            <button id="button-form-create" type="submit" class="btn btn-primary">
                @icon('plus', 'belich::buttons.crud.create')
            </button>
        </div>
    </form>
@endsection

{{-- Javascript from packages --}}
@section('javascript')
    {!! $request->javascript !!}
@endsection
