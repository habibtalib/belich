{{-- Options --}}
<div id="mass-delete-container" class="hidden button-selected">
    {{-- Set button icon --}}
    <a href="#modal-mass-delete" class="btn btn-dropdown border border-red-light mr-2 bg-red-lightest text-red-dark hover:bg-red-light hover:text-white" onclick="deleteSelectedFields('delete_selected');">
        @icon('trash', '', 'opacity-100')
    </a>
</div>

{{-- Modal --}}
@include('belich::dashboard.modals.mass-delete')
