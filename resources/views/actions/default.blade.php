@can('view', $autorizedModel)
    <a href="{{ Belich::actionRoute('show', $data) }}" class="action">@actionIcon('eye')</a>
@endcan

@can('update', $autorizedModel)
    <a href="{{ Belich::actionRoute('edit', $data) }}" class="action">@actionIcon('edit')</a>
@endcan

@can('delete', $autorizedModel)
    <a href="{{ Belich::actionRoute('destroy', $data) }}" class="action">@actionIcon('trash')</a>
@endcan
