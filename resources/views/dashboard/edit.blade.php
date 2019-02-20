@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.navigation.breadcrumbs')

    {{-- Crud Button: show --}}
    @component('belich::components.crud-button')
        @slot('url', Belich::actionRoute('show', $request->id))
        @slot('icon', icon('eye', trans('belich::buttons.crud.show')))
    @endcomponent

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
    @include('belich::partials.containers.rounded-bottom')
@endsection

{{-- Javascript from packages --}}
@section('javascript')
    {!! $request->javascript !!}
@endsection
