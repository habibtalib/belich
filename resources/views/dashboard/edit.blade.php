@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.navigation.breadcrumbs')

    {{-- Crud Button: navigation to show --}}
    <belich::button-navigation :title="icon('eye', trans('belich::buttons.crud.show'))" :url="Belich::actionRoute('show', $request->id)" loading/>

    {{-- Form --}}
    <form method="POST" name="form-{{ $request->name }}-edit" id="form-{{ $request->name }}-edit" action="{{ toRoute('update') }}">
        @csrf
        @method('PATCH')

        {{-- Create panels --}}
        @foreach($request->fields as $label => $panel)
            {{-- Load panel component with its fields --}}
            <belich::panel :label="$label" :panel="$panel" :loop="$loop" toField></belich::panel>
        @endforeach

        {{-- Button: update --}}
        <div class="btn-container bg-blue-lightest">
            {{-- Button: create --}}
            <belich::button
                id="button-form-edit"
                type="button"
                color="primary"
                :title="icon('edit', trans('belich::buttons.crud.update'))"
                loading
            />
        </div>
    </form>

    {{-- Form bottom border rounded --}}
    @includeIf('belich::partials.containers.rounded-bottom')
@endsection

{{-- Javascript from packages --}}
@push('javascript')
    {!! $request->javascript !!}
@endpush
