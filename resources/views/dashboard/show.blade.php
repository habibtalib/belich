@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.navigation.breadcrumbs')

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
    <belich::bottom>
        {{-- Button: create --}}
        <slot name="button">
            <belich::button
                :title="icon('plus')"
                :url="Belich::actionRoute('create')"
                class="mr-2"
                color="icon"
                loading
            />
            {{-- Button: edit --}}
            <belich::button
                :title="icon('edit')"
                :url="Belich::actionRoute('edit', $request->id)"
                color="icon"
                loading
            />
        </slot>
    </belich::bottom>
@endsection

{{-- Added the minimum javascript possible --}}
@push('javascript')
    @include('belich::dashboard.javascript.forms')
@endpush
