@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.navigation.breadcrumbs')

    <div id="form-container-group" class="px-4">
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
            <slot name="button">
                {{-- Button: create --}}
                @can('create', $request->autorizedModel)
                    <belich::button
                        :title="Helper::icon('plus')"
                        :url="Belich::actionRoute('create')"
                        dusk="button-action-create"
                        class="mr-2"
                        color="icon"
                        loading
                    />
                @endcan
                {{-- Button: edit --}}
                @can('update', $request->autorizedModel)
                    <belich::button
                        :title="Helper::icon('edit')"
                        :url="Belich::actionRoute('edit', $request->id)"
                        dusk="button-action-edit"
                        color="icon"
                        loading
                    />
                @endcan
            </slot>
        </belich::bottom>
    </div>
@endsection

{{-- Added the minimum javascript possible --}}
@push('javascript')
    @include('belich::dashboard.javascript.forms')
@endpush
