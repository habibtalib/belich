@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.navigation.breadcrumbs')

    {{-- Form --}}
    <form method="POST" name="form-{{ $request->name }}-create" id="form-{{ $request->name }}-create" action="{{ toRoute('store') }}" class="form-container">
        @csrf

        {{-- Include the fields by type --}}
        @foreach($request->fields as $field)
            @includeIf('belich::fields.' . $field->type, ['field' => $field])
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
