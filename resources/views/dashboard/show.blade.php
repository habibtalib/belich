@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.navigation.breadcrumbs')

    {{-- Crud Button: edit --}}
    <belich::button-navigation :title="icon('edit', trans('belich::buttons.crud.update'))" :url="Belich::actionRoute('edit', $request->id)" loading/>

    {{-- Show resource fields --}}
    <div class="form-container">
        @foreach($request->fields as $field)
            @if(!empty($field->label))
                <belich::fields :label="$field->label" :field="Belich::html()->resolve($field)"></belich::fields>
            @endif
        @endforeach
    </div>

    {{-- Container bottom border rounded --}}
    @includeIf('belich::partials.containers.rounded-bottom', ['height' => 'h-16'])
@endsection
