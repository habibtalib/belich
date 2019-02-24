{{-- Options --}}
<div id="exports-container" class="hidden button-selected btn btn-dropdown border border-green-light mr-2 bg-green-lightest text-green-dark hover:bg-green-light hover:text-white">
    {{-- Set button icon --}}
    @icon('download', '', 'opacity-100')

    {{-- Start with form --}}
    <form method="POST"
        name="belich-form-exports"
        id="belich-form-exports"
        dusk="dusk-form-exports"
        class="btn-dropdown-content pin-r rounded-lg border border-grey shadow text-grey-dark text-left bg-white"
        action="{{ route('dashboard.exports.download') }}"
    >
        @csrf

        <input type="hidden" name="resource_model" value="{{ Belich::getModelPath() }}">
        <input type="hidden" id="exports_selected" name="exports_selected" value="">

        {{-- Export format --}}
        @component('belich::components.options')
            @slot('css', 'rounded-t-lg')
            @slot('text', trans('belich::default.format'))
            @slot('field', 'format')
            @slot('required', true)
            @slot('options', [
                ['' => ''],
                ['xls' => 'Excel 2003'],
                ['xlsx' => 'Excel 2007'],
                ['csv' => 'CSV'],
            ])
        @endcomponent

        {{-- Export format --}}
        @component('belich::components.options')
            @slot('text', trans('belich::default.items'))
            @slot('field', 'quantity')
            @slot('required', true)
            @slot('options', [
                ['' => ''],
                ['all' => trans('belich::default.all')],
                ['selected' => trans('belich::default.selected')],
            ])
        @endcomponent

        <div class="float-right p-2 mb-2">
            <button type="submit" class="btn btn-default" onclick="addCheckboxesToField('exports_selected');">{!! icon('download', trans('belich::buttons.base.download')) !!}</button>
        </div>
    </form>
</div>
