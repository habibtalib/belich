{{-- Options --}}
<div id="exports-container" class="hidden button-selected btn btn-dropdown border border-green-400 mr-2 bg-green-200 text-green-600 hover:bg-green-400 hover:text-white">
    {{-- Set button icon --}}
    @icon('download', '', 'opacity-100')

    {{-- Start with form --}}
    <form method="POST" action="{{ route('dashboard.exports.download') }}" name="belich-form-exports" id="belich-form-exports" dusk="dusk-form-exports" class="btn-dropdown-content right-0 rounded-lg border border-gray-500 shadow text-gray-600 text-left bg-white">
        @csrf
        <input type="hidden" name="resource_model" value="{{ Belich::getModelPath() }}">
        <input type="hidden" id="exports_selected" name="exports_selected" value="">

        {{-- Export format component --}}
        <belich::options field="format" css="rounded-t-lg" required="true" :text="trans('belich::default.format')">
            <slot name="options">
                <option value="xls">Excel 2003</option>
                <option value="xlsx">Excel 2007</option>
                <option value="csv">CSV</option>
            </slot>
        </belich::options>

        {{-- Export quantity component --}}
        <belich::options field="quantity" css="rounded-t-lg" required="true" :text="trans('belich::default.items')">
            <slot name="options">
                <option value="all">@lang('belich::default.all')</option>
                <option value="selected">@lang('belich::default.selected')</option>
            </slot>
        </belich::options>

        <div class="float-right p-2 mb-2">
            <button type="submit" class="btn btn-default" onclick="addCheckboxesToField('exports_selected');">{!! icon('download', trans('belich::buttons.base.download')) !!}</button>
        </div>
    </form>
</div>
