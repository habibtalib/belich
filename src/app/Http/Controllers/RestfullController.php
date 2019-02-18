<?php

namespace Daguilarm\Belich\App\Http\Controllers;

use Daguilarm\Belich\App\Http\Controllers\BaseController;
use Daguilarm\Belich\Core\Belich;
use Illuminate\Http\Request;

class RestfullController extends BaseController
{
    /** @var Illuminate\Database\Eloquent\Model */
    protected $model;

    /**
     * Generate crud controllers
     *
     * @param Daguilarm\Belich\Core\Belich $belich
     */
    public function __construct(Belich $belich, Request $request)
    {
        parent::__construct($belich, $request);

        //Get resource model
        $this->model = Belich::getModel();
    }

    /**
     * List the resources.
     *
     * @param Daguilarm\Belich\Core\Belich $belich
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Belich $belich, Request $request)
    {
        //Authorization
        $this->authorize('viewAny', $this->model);

        //Get all the data
        $request = $this->getData($belich, $request);

        return view('belich::dashboard.index', compact('request'));
    }

    /**
     * Create a new resource.
     *
     * @param Daguilarm\Belich\Core\Belich $belich
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Belich $belich, Request $request)
    {
        //Authorization
        $this->authorize('create', $this->model);

        //Get the data
        $request = $this->getFormData($belich, $request);

        return view('belich::dashboard.create', compact('request'));
    }

    /**
     * Store a new resource.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Authorization
        $this->authorize('create', $this->model);

        $create = $this->model::create($request->all());

        return $this->redirectToAction($create, $actionSuccess = 'created', $actionFail = 'creating', $id = $create->id);
    }

    /**
     * Show the a resource.
     *
     * @param Daguilarm\Belich\Core\Belich $belich
     * @param int $id
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Belich $belich, $id, Request $request)
    {
        //The autorization magic happens in the Daguilarm\Belich\Fields\FieldResolve::class
        //in order to avoid duplicate mySql queries
        //This controller use the: $this->authorize('view')

        //Get the data
        $request = $this->getFormData($belich, $request, $id);

        return view('belich::dashboard.show', compact('request'));
    }

    /**
     * Edit a resource.
     *
     * @param Daguilarm\Belich\Core\Belich $belich
     * @param int $id
     * @param Illuminate\Http\Request $request
     */
    public function edit(Belich $belich, $id, Request $request)
    {
        //The autorization magic happens in the Daguilarm\Belich\Fields\FieldResolve::class
        //in order to avoid duplicate mySql queries
        //This controller use the: $this->authorize('update')

        //Get the data
        $request = $this->getFormData($belich, $request, $id);

        return view('belich::dashboard.edit', compact('request'));
    }

    /**
     * Update a resource.
     *
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //The autorization magic happens in the Daguilarm\Belich\Fields\FieldResolve::class
        //in order to not duplicate code...(in this case, the sql duplicate queries is not an issue)
        //This controller use the: $this->authorize('update')

        $update = $this->model->findOrFail($id)->update($request->all());

        return $this->redirectToAction($update, $actionSuccess = 'updated', $actionFail = 'updating', $id);
    }

    /**
     * Delete a resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //Authorization
        $this->authorize('delete', $this->model);

        $delete = $this->model->findOrFail($id)->delete();

        return $this->redirectToAction($delete, $actionSuccess = 'deleted', $actionFail = 'deleting', $id);
    }

    /**
     * Force delete a resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function forceDelete($id)
    {
        //Authorization
        $this->authorize('forceDelete', $this->model);

        $forceDelete = $this->whereDeletedID($id)->forceDelete();

        return $this->redirectToAction($forceDelete, $actionSuccess = 'force deleted', $actionFail = 'force deleting', $id);
    }

    /**
     * Restore a deleted a resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        //Authorization
        $this->authorize('restore', $this->model);

        //Restore deleted row
        $restore = $this->whereDeletedID($id)->restore();

        return $this->redirectToAction($restore, $actionSuccess = 'restored', $actionFail = 'restoring', $id);
    }
}
