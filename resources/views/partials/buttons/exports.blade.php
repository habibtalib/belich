{{-- Options --}}
<div class="btn btn-dropdown border border-green-light mr-2 bg-green-lightest text-green-dark hover:bg-green-light hover:text-white">
    {{-- Set button icon --}}
    @icon('download', '', 'opacity-100')

    {{-- Start with form --}}
    <form method="POST"
        name="belich-form-exports"
        id="belich-form-exports"
        dusk="dusk-form-exports"
        class="btn-dropdown-content pin-r rounded-lg border border-grey shadow text-grey-dark text-left bg-white"
        action="/"
    >
        @csrf

        {{-- Export format --}}
        @component('belich::components.options')
            @slot('css', 'rounded-t-lg')
            @slot('text', trans('belich::default.format'))
            @slot('field', 'exports')
            @slot('options', [
                ['pdf' => 'PDF'],
                ['xls' => 'Excel'],
                ['csv' => 'CSV'],
            ])
        @endcomponent

        {{-- Export format --}}
        @component('belich::components.options')
            @slot('text', trans('belich::default.items'))
            @slot('field', 'exports_quantity')
            @slot('options', [
                trans('belich::default.all'),
                trans('belich::default.selected')
            ])
        @endcomponent

        <div class="float-right p-2 mb-2">
            <button type="submit" class="btn btn-default">{!! icon('download', trans('belich::buttons.base.download')) !!}</button>
        </div>
    </form>
</div>
