@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.navigation.breadcrumbs')

    {{-- Crud Button: edit --}}
    <belich::button-navigation :title="icon('edit', trans('belich::buttons.crud.update'))" :url="Belich::actionRoute('edit', $request->id)" loading/>

    {{-- Create panels --}}
    @foreach($request->fields as $label => $panel)
        {{-- Load panel component with its fields --}}
        <belich::panel :label="$label" :panel="$panel" :loop="$loop"></belich::panel>
    @endforeach

    {{-- Bottom container --}}
    {{-- Just empty because there is no button... --}}
    <belich::bottom height="10">
        <slot name="button"></slot>
    </belich::bottom>
@endsection
