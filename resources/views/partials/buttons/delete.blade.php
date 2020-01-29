{{-- Delete --}}
<div id="mass-delete-container" class="hidden button-selected">
    {{-- Set button icon --}}
    <a href="#modal-mass-delete" dusk="button-options-delete" class="btn btn-dropdown rounded-lg mr-2 bg-red-200 text-red-600 hover:bg-red-400 hover:text-white" onclick="deleteSelectedFields('delete_selected');">
        @icon('b-trash', '', 'opacity-100')
    </a>
</div>

@prepend('modals')
    {{-- Modal component: delete selected - mass --}}
    <belich::modal form="true" id="mass-delete" dusk="modal-mass-delete" hidden="delete_selected" background="red-400" color="white" :action="route('dashboard.' . $request->name . '.delete.selected')" :request="$request" :header="Helper::icon('b-exclamation', trans('belich::messages.delete.selected.title'))">

        {{-- Modal content --}}
        <slot name="content">
            <div>@icon('b-ok', 'belich::messages.delete.selected.confirm')</div>
        </slot>

        {{-- Modal footer --}}
        <slot name="footer">
            <a href="#" class="btn btn-default mx-2 close">@lang('belich::buttons.actions.cancel')</a>
            <button class="btn btn-success mx-2" dusk="modal-mass-delete-confirm-button" onclick="loading(this);">@lang('belich::buttons.actions.confirm')</button>
        </slot>

    </belich::modal>
@endprepend
