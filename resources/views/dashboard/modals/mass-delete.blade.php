@component('belich::components.modal')
    @slot('form', true)
    @slot('request', $request)
    @slot('containerID', 'mass-delete')
    @slot('background', 'red')
    @slot('color', 'white')
    @slot('title', icon('trash', 'Mass delete'))
    @slot('content')
        <li>Are you sure you want to delete all the selected fields?</li>
    @endslot
    @slot('footer')
        <a href="#" class="btn btn-default mx-2 close">Cancel</a>
        <button class="btn btn-success mx-2">Confirm</button>
    @endslot
@endcomponent
