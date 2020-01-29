{{-- If the model results has been trashed --}}
@hasSoftdeletedResults($model)
    {{-- The user can restore trashed items --}}
    @can('restore', $model)
        <a href="{{ Belich::actionRoute('restore', $model) }}" dusk="action-restore-{{ $model->id}}" class="text-gray text-lg p-1 hover:text-gray-600">{!! Helper::icon('redo') !!}</a>
    @endcan
    {{-- The user can force delete trashed items --}}
    @can('forceDelete', $model)
        <a href="{{ Belich::actionRoute('forceDelete', $model) }}" dusk="action-forceDelete-{{ $model->id}}" class="text-gray-500 text-lg p-1 hover:text-gray-600 bg-red-lightest rounded-full">{!! Helper::icon('trash-alt') !!}</a>
    @endcan

{{-- Regular model results --}}
@else
    @can('view', $model)
        <a href="{{ Belich::actionRoute('show', $model) }}" dusk="action-view-{{ $model->id}}" class="text-gray-500 text-lg p-1 hover:text-gray-600">{!! Helper::icon('b-show') !!}</a>
    @endcan

    @can('update', $model)
        <a href="{{ Belich::actionRoute('edit', $model) }}" dusk="action-update-{{ $model->id}}" class="text-gray-500 text-lg p-1 hover:text-gray-600">{!! Helper::icon('b-edit') !!}</a>
    @endcan

    @can('delete', $model)
        <a href="#modal-item-delete" data-id="{{ $model->id }}" dusk="action-delete-{{ $model->id}}" class="text-gray-500 text-lg p-1 hover:text-gray-600" onclick="deleteField('form-item-delete', '{{ Belich::actionRoute('destroy', $model) }}');">
            {!! Helper::icon('b-delete') !!}
        </a>
    @endcan
@endif
