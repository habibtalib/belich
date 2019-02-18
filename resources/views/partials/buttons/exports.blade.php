{{-- Options --}}
<div class="btn btn-dropdown bg-green-lightest text-green-dark border border-green-light hover:bg-green-light hover:text-white">
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
            @slot('text', 'Format')
            @slot('icon', 'file')
            @slot('field', 'exports')
            @slot('options', [
                ['pdf' => 'PDF'],
                ['xls' => 'Excel'],
                ['csv' => 'CSV'],
            ])
        @endcomponent

        {{-- Export format --}}
        @component('belich::components.options')
            @slot('text', 'Quantity')
            @slot('icon', 'check-square')
            @slot('field', 'exports_quantity')
            @slot('options', ['all', 'selected'])
        @endcomponent

        <div class="float-right p-2 mb-2">
            <button type="submit" class="btn btn-default">{!! icon('download', 'Download') !!}</button>
        </div>
    </form>
</div>
