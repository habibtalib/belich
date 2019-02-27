{{-- Options --}}
<div class="btn btn-dropdown border border-grey mr-2 bg-grey-lighter text-grey-dark hover:bg-grey hover:text-white">
    {{-- Set button icon --}}
    @icon('cogs', '', 'opacity-100')

    {{-- Start with form --}}
    <form method="POST" action="{{ route('dashboard.users.settings') }}" name="belich-form-options" id="belich-form-options" dusk="dusk-form-options" class="btn-dropdown-content pin-r rounded-lg border border-grey shadow text-grey-dark text-left bg-white">
        @csrf

        {{-- Per page component --}}
        <belich::options field="perPage" css="rounded-t-lg" :text="trans('belich::default.perPage')">
            <slot name="options">
                <option></option>
                @foreach(range(10, 50, 10) as $option)
                    <option value="{{ $option }}">{{ $option }}</option>
                @endforeach
                <option value="100">100</option>
                <option value="300">300</option>
                <option value="500">500</option>
            </slot>
        </belich::options>

        {{-- Trashed component --}}
        @can('withTrashed', $request->autorizedModel)
            @hasSoftdelete($request->autorizedModel)
                <belich::options field="withTrashed" css="rounded-t-lg" :text="trans('belich::default.trashed')">
                    <slot name="options">
                        <option></option>
                        <option value="none">@lang('belich::default.none')</option>
                        <option value="all">@lang('belich::default.all')</option>
                        <option value="only">@lang('belich::default.trashedOnly')</option>
                    </slot>
                </belich::options>
            @endif
        @endcan

        <div class="float-right p-2 mb-2">
            <button type="submit" class="btn btn-default" onclick="loading(this);">{!! icon('redo-alt', trans('belich::buttons.base.configure')) !!}</button>
        </div>
    </form>
</div>
