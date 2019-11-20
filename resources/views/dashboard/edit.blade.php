@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.navigation.breadcrumbs')

    {{-- Form --}}
    <div id="form-container-group" class="px-4">
        <form method="POST" enctype="multipart/form-data" name="form-{{ $request->name }}-edit" id="form-{{ $request->name }}-edit" action="{{ Helper::toRoute('update') }}">
            @csrf
            @method('PATCH')

            {{-- Building tabs --}}
            @if(Belich::tabs())
                <belich::tabs :tabs="$request->fields" toField="true"></belich::tabs>

            {{-- Building panels --}}
            @else
                {{-- Create panels or not.. --}}
                @foreach($request->fields as $label => $panel)
                    {{-- Load panel component with its fields --}}
                    <belich::panel :label="$label" :panel="$panel" :loop="$loop" toField="true"></belich::panel>
                @endforeach
            @endif

            {{-- Bottom container --}}
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
                    {{-- Button: show --}}
                    @can('view', $request->autorizedModel)
                        <belich::button
                            :title="Helper::icon('eye')"
                            :url="Belich::actionRoute('show', $request->id)"
                            dusk="button-action-show"
                            color="icon"
                            loading
                        />
                    @endcan
                    {{-- Button: edit --}}
                    @can('update', $request->autorizedModel)
                        <belich::button
                            id="button-form-edit"
                            dusk="button-action-edit"
                            type="button"
                            color="primary"
                            :title="Helper::icon('edit', trans('belich::buttons.crud.update'))"
                        />
                    @endcan
                </slot>
            </belich::bottom>
        </form>
    </div>
@endsection

{{-- Added the minimum javascript possible --}}
@push('javascript')
    @include('belich::dashboard.javascript.forms')
    {{-- Server side javascript --}}
    {!! $request->javascript !!}
@endpush
