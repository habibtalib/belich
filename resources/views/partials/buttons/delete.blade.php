{{-- Options --}}
<div id="mass-delete-container" class="hidden button-selected">
    {{-- Set button icon --}}
    <a href="#modal-mass-delete" class="btn btn-dropdown border border-red-light mr-2 bg-red-lightest text-red-dark hover:bg-red-light hover:text-white" onclick="deleteSelectedFields('delete_selected');">
        @icon('trash', '', 'opacity-100')
    </a>
</div>

{{-- Modal component --}}
<belich::modal form="true" id="mass-delete" hidden="delete_selected" background="red" color="white" :action="route('dashboard.' . $request->name . '.delete.selected')" :request="$request" :icon="icon('trash', 'Mass delete')" :title="trans('belich::messages.delete.selected.title')">
    {{-- Modal content --}}
    <slot name="content">
        <div>@icon('check-square', 'belich::messages.delete.selected.confirm')</div>
    </slot>
    {{-- Modal footer --}}
    <slot name="footer">
        <a href="#" class="btn btn-default mx-2 close">@lang('belich::buttons.actions.cancel')</a>
        <button class="btn btn-success mx-2">@lang('belich::buttons.actions.confirm')</button>
    </slot>
</belich::modal>
