@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.navigation.breadcrumbs')

    {{-- Form --}}
    <form method="POST" enctype="multipart/form-data" name="form-{{ $request->name }}-edit" id="form-{{ $request->name }}-edit" action="{{ toRoute('update') }}">
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
                        :title="icon('plus')"
                        :url="Belich::actionRoute('create')"
                        class="mr-2"
                        color="icon"
                        loading
                    />
                @endcan
                {{-- Button: show --}}
                @can('view', $request->autorizedModel)
                    <belich::button
                        :title="icon('eye')"
                        :url="Belich::actionRoute('show', $request->id)"
                        color="icon"
                        loading
                    />
                @endcan
                {{-- Button: edit --}}
                @can('update', $request->autorizedModel)
                    <belich::button
                        id="button-form-edit"
                        type="button"
                        color="primary"
                        :title="icon('edit', trans('belich::buttons.crud.update'))"
                    />
                @endcan
            </slot>
        </belich::bottom>
    </form>
@endsection

{{-- Javascript from packages --}}
@push('javascript')
    {!! $request->javascript !!}

    {{-- Javascript for tabs --}}
    @include('belich::dashboard.javascript.forms')
@endpush
