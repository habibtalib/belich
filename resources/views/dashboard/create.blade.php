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

        {{-- Bottom border rounded  --}}
        <div class="btn-container bg-blue-lightest">
            {{-- Button: create --}}

            <belich::button
                type="button"
                color="primary"
                :title="icon('plus', trans('belich::buttons.crud.create'))"
                id="button-form-create"
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
