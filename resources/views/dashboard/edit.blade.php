@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.navigation.breadcrumbs')

    {{-- Buttons --}}
    <div class="flex w-full justify-end">
        <a href="{{ Belich::actionRoute('show', $request->id) }}" class="btn btn-secondary mb-4">
            @icon('eye', 'belich::buttons.crud.show')
        </a>
    </div>

    <form method="POST" name="form-{{ $request->name }}-edit" id="form-{{ $request->name }}-edit" action="{{ toRoute('update') }}" class="form-container">
        @csrf
        @method('PATCH')

        {{-- Include the fields by type --}}
        @foreach($request->fields as $field)
            @includeIf('belich::fields.' . $field->type, ['field' => $field])
        @endforeach

        {{-- Buttons --}}
        <div class="btn-container bg-blue-lightest">
            <button id="button-form-edit" type="submit" class="btn btn-primary">
                @icon('edit', 'belich::buttons.crud.update')
            </button>
        </div>
    </form>
@endsection

{{-- Javascript from packages --}}
@section('javascript')
    {!! $request->javascript !!}
@endsection
