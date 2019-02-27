@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.navigation.breadcrumbs')

    {{-- Crud Button: edit --}}
    <belich::button :title="icon('edit', trans('belich::buttons.crud.update'))" :url="Belich::actionRoute('edit', $request->id)"/>

    {{-- Show resource fields --}}
    @foreach($request->fields as $field)
        @if(!empty($field->label))
            <div class="form-container">
                @component('belich::fields.components.inlineForm')
                    @slot('label', $field->label)
                    @slot('field')
                        {!! Belich::html()->resolve($field) !!}
                    @endslot
                @endcomponent
            </div>
        @endif
    @endforeach

    {{-- Container bottom border rounded --}}
    @includeIf('belich::partials.containers.rounded-bottom', ['height' => 'h-16'])
@endsection
