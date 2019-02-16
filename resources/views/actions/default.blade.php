@can('view', $model)
    <a href="{{ Belich::actionRoute('show', $model) }}" class="action">@actionIcon('eye')</a>
@endcan

@can('update', $model)
    <a href="{{ Belich::actionRoute('edit', $model) }}" class="action">@actionIcon('edit')</a>
@endcan

@can('delete', $model)
    <a href="{{ Belich::actionRoute('destroy', $model) }}" class="action">@actionIcon('trash')</a>
@endcan
