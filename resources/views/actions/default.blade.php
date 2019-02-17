@can('view', $model)
    <a href="{{ Belich::actionRoute('show', $model) }}" class="action">@actionIcon('eye')</a>
@endcan

@can('update', $model)
    <a href="{{ Belich::actionRoute('edit', $model) }}" class="action">@actionIcon('edit')</a>
@endcan

@can('delete', $model)
    {{-- If the model has been trashed --}}
    @isTrashed($model)
        {{-- The user can restore trashed items --}}
        @can('restore', $model)
            <a href="{{ Belich::actionRoute('destroy', $model) }}" class="action">@actionIcon('redo')</a>
        @endcan
        {{-- The user can force delete trashed items --}}
        @can('forceDelete', $model)
            <a href="{{ Belich::actionRoute('destroy', $model) }}" class="action bg-red-lightest rounded-full">@actionIcon('trash-alt')</a>
        @endcan
    {{-- Just the regular deleting... --}}
    @else
        <a href="{{ Belich::actionRoute('destroy', $model) }}" class="action">@actionIcon('trash')</a>
    @endif
@endcan
