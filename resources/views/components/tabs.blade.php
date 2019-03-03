<div class="tabs">
    {{-- Create tabs links --}}
    <ul class="list-reset bg-grey-lightest py-4 shadow-md">

        {{-- List the tab links --}}
        @foreach($tabs as $label => $panel)
            <li class="inline m-0">
                <a
                    id="menu_{{ stringTokebab($label) }}"
                    onclick="javascript:switchTab('{{ stringTokebab($label) }}', '{{ md5(stringTokebab($label)) }}');"
                    href="#{{ md5(stringTokebab($label)) }}"
                    class="p-4 px-6 text-grey-darker border border-b-0 border-grey-lighter {{ $loop->first ? 'active' : '' }}"
                >
                    {{ $label }}
                </a>
            </li>
        @endforeach
    </ul>

    {{-- List the tab containers --}}
    @foreach($tabs as $label => $panel)
        <div class="content {{ $loop->first ? 'block' : 'hidden' }}" id="content_{{ stringTokebab($label) }}">

            {{-- Form --}}
            @isset($toField)
                <belich::panel :label="$label" :panel="$panel" :loop="$loop" toField></belich::panel>

            {{-- Detail --}}
            @else
                <belich::panel :label="$label" :panel="$panel" :loop="$loop"></belich::panel>
            @endif
        </div>
    @endforeach
</div>

{{-- Custom active tab --}}
@push('css')
    <style>
        .tabs li a.active {
            background-color: white;
            font-weight: 700;
            color: #3490dc;
            border: 0;
            border-bottom: 1px solid #3490dc;
        }
    </style>
@endpush
