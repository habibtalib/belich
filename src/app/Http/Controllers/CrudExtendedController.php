<?php

namespace Daguilarm\Belich\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Daguilarm\Belich\App\Http\Controllers\Traits\Deletedable;
use Daguilarm\Belich\App\Http\Controllers\Traits\Redirectable;
use Daguilarm\Belich\Core\Belich;
use Daguilarm\Belich\Facades\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

final class CrudExtendedController extends Controller
{
    use Deletedable, Redirectable;

    /** @var Illuminate\Database\Eloquent\Model */
    protected $model;

    /**
     * Generate crud controllers
     *
     * @param Daguilarm\Belich\Core\Belich $belich
     */
    public function __construct(Belich $belich)
    {
        //Get resource model
        $this->model = Belich::getModel();
    }

    /**
     * Force delete a resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
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
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
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
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
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
