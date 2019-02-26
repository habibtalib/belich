@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.navigation.breadcrumbs')

    {{-- Crud Button: show --}}
    <belich::button
        type="show"
        :id="$request->id"
        :icon="icon('eye', trans('belich::buttons.crud.show'))"
    />

    <form method="POST" name="form-{{ $request->name }}-edit" id="form-{{ $request->name }}-edit" action="{{ toRoute('update') }}" class="form-container">
        @csrf
        @method('PATCH')

        {{-- Include the fields by type --}}
        @foreach($request->fields as $field)
            @includeIf('belich::fields.' . $field->type, ['field' => $field])
        @endforeach

        {{-- Buttons --}}
        <div class="btn-container bg-blue-lightest">
            <button id="button-form-edit" type="submit" class="btn btn-primary mt-1">
                @icon('edit', 'belich::buttons.crud.update')
            </button>
        </div>
    </form>
    {{-- Form border rounded --}}
    @includeIf('belich::partials.containers.rounded-bottom')
@endsection

{{-- Javascript from packages --}}
@section('javascript')
    {!! $request->javascript !!}
@endsection
