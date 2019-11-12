{{-- Options --}}
<div id="options-container" dusk="button-options-options" class="btn btn-dropdown border border-gray-500 mr-2 bg-gray-200 text-gray-600 hover:bg-gray-500 hover:text-white">
    {{-- Set button icon --}}
    @icon('cogs', '', 'opacity-100')

    <div class="btn-dropdown-content">
        <div class="btn-dropdown-content-item rounded-lg border border-gray-500 shadow text-gray-600 text-left bg-white">
            {{-- Start with form --}}
            <form method="POST" action="{{ route('dashboard.users.settings') }}" name="belich-form-options" id="belich-form-options" dusk="dusk-form-options">
                @csrf

                {{-- Per page component --}}
                <belich::options field="perPage" css="rounded-t-lg" :text="trans('belich::default.perPage')">
                    <slot name="options">
                        {!! Helper::createFormSelectOptions([10, 20, 30, 50, 100, 200, 300, 500], 'perPage') !!}
                    </slot>
                </belich::options>

                {{-- Trashed component --}}
                @can('withTrashed', $request->autorizedModel)
                    {{-- If the model has softdelete --}}
                    @hasSoftdelete($request->autorizedModel)
                        <belich::options field="withTrashed" :text="trans('belich::default.trashed')">
                            <slot name="options">
                                {!! Helper::createFormSelectOptions([
                                    'none' => trans('belich::default.none'),
                                    'all'  => trans('belich::default.all'),
                                    'only' => trans('belich::default.trashedOnly'),
                                ], 'withTrashed') !!}
                            </slot>
                        </belich::options>
                    @endif
                @endcan

                {{-- Submit buttons --}}
                <div class="w-full flex flex-row-reverse p-2 mb-2">
                    <button type="submit" class="btn btn-default" dusk="table-options-submit" onclick="loading(this);">
                        {!! Helper::icon('redo-alt', trans('belich::buttons.base.configure')) !!}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
