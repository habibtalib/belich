{{-- Options --}}
<div>
    {{-- Set button icon --}}
    <a href="#" class="btn btn-dropdown border border-red-light mr-2 bg-red-lightest text-red-dark hover:bg-red-light hover:text-white" onclick="deleteSelectedFields('delete_selected');">
        @icon('trash', '', 'opacity-100')
    </a>

    {{-- Start with form --}}
    <form method="POST"
        name="belich-form-delete-selected"
        id="belich-form-delete-selected"
        dusk="dusk-form-delete-selected"
        action="{{ route('dashboard.' . $request->name . '.delete.selected') }}"
    >
        @csrf
        <input type="hidden" id="delete_selected" name="delete_selected" value="">
    </form>
</div>
