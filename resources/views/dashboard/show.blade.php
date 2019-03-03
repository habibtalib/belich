@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.navigation.breadcrumbs')

    {{-- Crud Button: edit --}}
    <belich::button-navigation :title="icon('edit', trans('belich::buttons.crud.update'))" :url="Belich::actionRoute('edit', $request->id)" loading/>

    {{-- Building tabs --}}
    @if(Belich::tabs())
        <belich::tabs :tabs="$request->fields"></belich::tabs>

    {{-- Building panels --}}
    @else
        {{-- Create panels or not.. --}}
        @foreach($request->fields as $label => $panel)
            {{-- Load panel component with its fields --}}
            <belich::panel :label="$label" :panel="$panel" :loop="$loop"></belich::panel>
        @endforeach
    @endif

    {{-- Bottom container --}}
    {{-- Just empty because there is no button... --}}
    <belich::bottom height="12"></belich::bottom>
@endsection

{{-- Added the minimum javascript possible --}}
@push('javascript')
    @include('belich::dashboard.javascript.forms')
@endpush
