<div class="tabs">
    {{-- Create tabs links --}}
    <ul class="list-reset py-4 shadow-md">
        {{-- List the tab links --}}
        @foreach($tabs as $label => $panel)
            <li class="inline m-0" id="tab-link-{{ md5(Helper::stringTokebab($label)) }}">
                <a
                    id="menu_{{ Helper::stringTokebab($label) }}"
                    onclick="javascript:switchTab('{{ Helper::stringTokebab($label) }}', '{{ md5(Helper::stringTokebab($label)) }}');"
                    href="#{{ md5(Helper::stringTokebab($label)) }}"
                    class="p-4 px-6 text-gray-700 border border-b-0 border-gray-200 {{ $loop->first ? 'active' : '' }}"
                >
                    {{ $label }}
                </a>
            </li>
        @endforeach
    </ul>

    {{-- List the tab containers --}}
    @foreach($tabs as $label => $panel)
        <div class="content {{ $loop->first ? 'block' : 'hidden' }}" id="content_{{ Helper::stringTokebab($label) }}">

            {{-- Form --}}
            @isset($toField)
                <belich::panel :label="$label" :panel="$panel" :loop="$loop" toField="true"></belich::panel>
            {{-- Detail --}}
            @else
                <belich::panel :label="$label" :panel="$panel" :loop="$loop"></belich::panel>
            @endif

        </div>
    @endforeach
</div>

@push('javascript')
    <script>
        //Tabs system for forms
        function switchTab(id, key) {
            //Default value
            var currentTab;
            // Prevent doubble click
            if(currentTab === key) { return false; }
            //Get all the tabs and containers
            var elements = document.querySelectorAll('.content');
            var container = document.getElementById('content_' + id);
            //Hide all the containers
            for (var i = 0; i < elements.length; i++) {
                elements[i].classList.add('hidden'), elements[i].classList.remove('block');
            }
            //Set visible
            container.classList.remove('hidden'), container.classList.add('block');
            //Add active
            document.querySelector('.tabs ul li a.active').classList.remove('active');
            document.getElementById('menu_' + id).classList.add('active');
            //Set current tab
            currentTab = key;
        }
    </script>
@endpush

{{-- Custom active tab --}}
@push('css')
    <style>
        .tabs li a {
            background-color: white;
            border: 0;
            border-bottom: 2px solid var(--20);
            margin: 0 1px;
        }
        .tabs li a.active {
            font-weight: 700;
            color: #3490dc;
            border-bottom: 2px solid #3490dc;
        }
        .tab-error {
            color: red !important;
            border-color: red !important;
        }
    </style>
@endpush
