<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Http\Controllers;

use App\Http\Controllers\Controller;
use Daguilarm\Belich\Core\Belich;
use Daguilarm\Belich\Facades\Helper;
use Daguilarm\Belich\Http\Controllers\Traits\Deletedable;
use Daguilarm\Belich\Http\Controllers\Traits\Redirectable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class CrudExtendedController extends Controller
{
    use Deletedable,
        Redirectable;

    protected object $model;

    public function __construct(Belich $belich)
    {
        //Get resource model
        $this->model = $belich->getModel();
    }

    /**
     * Force delete a resource.
     */
    public function forceDelete(int $id): RedirectResponse
    {
        //Authorization
        $this->authorize('forceDelete', $this->model);

        $forceDelete = $this->whereDeletedID($id)->forceDelete();

        return $this->redirectToAction($forceDelete, $actionSuccess = 'force deleted', $actionFail = 'force deleting', $id);
    }

    /**
     * Force delete a resource.
     */
    public function deleteSelected(Request $request): RedirectResponse
    {
        //Authorization
        $this->authorize('delete', $this->model);

        $deleteSelected = $this->model->whereIn('id', Helper::fieldToArray($request->delete_selected))->delete();

        return $this->redirectToAction($deleteSelected, $actionSuccess = 'Mass deleted', $actionFail = 'Mass deleting');
    }

    /**
     * Restore a deleted a resource.
     */
    public function restore(int $id): RedirectResponse
    {
        //Authorization
        $this->authorize('restore', $this->model);

        //Restore deleted row
        $restore = $this->whereDeletedID($id)->restore();

        return $this->redirectToAction($restore, $actionSuccess = 'restored', $actionFail = 'restoring', $id);
    }
}
