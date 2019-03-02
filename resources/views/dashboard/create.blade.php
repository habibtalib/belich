@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.navigation.breadcrumbs')

    {{-- Form --}}
    <form method="POST" name="form-{{ $request->name }}-create" id="form-{{ $request->name }}-create" action="{{ toRoute('store') }}">
        @csrf

        {{-- Create panels --}}
        @foreach($request->fields as $label => $panel)
            {{-- Load panel component with its fields --}}
            <belich::panel :label="$label" :panel="$panel" :loop="$loop" toField></belich::panel>
        @endforeach

        {{-- Bottom container --}}
        <belich::bottom>
            {{-- Button: create --}}
            <slot name="button">
                <belich::button
                    type="button"
                    color="primary"
                    :title="icon('plus', trans('belich::buttons.crud.create'))"
                    id="button-form-create"
                    loading
                />
            </slot>
        </belich::bottom>
    </form>
@endsection

{{-- Javascript from packages --}}
@push('javascript')
    {!! $request->javascript !!}
@endpush
