@extends(Request::ajax() ? 'belich::layout-ajax' : 'belich::layout')

@section('content')
    {{-- Breadcrumbs --}}
    @include('belich::partials.navigation.breadcrumbs')

    {{-- Form --}}
    <form method="POST" name="form-{{ $request->name }}-create" id="form-{{ $request->name }}-create" action="{{ toRoute('store') }}">
        @csrf

        {{-- Building tabs --}}
        @if(Belich::tabs())
            <div class="tabs">
                {{-- Create tabs links --}}
                <ul>
                    @foreach($request->fields as $label => $panel)
                        <li>
                            @php
                                $slug = Illuminate\Support\Str::kebab($label);
                            @endphp
                            <a href="javascript:switchTab('{{ $slug }}', 'content_{{ $slug }}');" id="{{ $slug }}" class="tab_menu {{ $loop->first ? 'active' : '' }}">
                                {{ $label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                @foreach($request->fields as $label => $panel)
                    <div class="tab_content {{ $loop->first ? 'block' : 'hidden' }}" id="content_{{ $slug }}">
                        <belich::panel :label="$label" :panel="$panel" :loop="$loop" toField></belich::panel>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Create panels --}}
            @foreach($request->fields as $label => $panel)
                {{-- Load panel component with its fields --}}
                <belich::panel :label="$label" :panel="$panel" :loop="$loop" toField></belich::panel>
            @endforeach
        @endif

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
