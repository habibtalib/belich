<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Http\Controllers;

use App\Http\Controllers\Controller;
use Daguilarm\Belich\Http\Controllers\Traits\Redirectable;
use Daguilarm\Belich\Http\Controllers\Traits\Relationable;
use Daguilarm\Belich\Http\Requests\CreateRequest;
use Daguilarm\Belich\Http\Requests\EditRequest;
use Daguilarm\Belich\Http\Requests\IndexRequest;
use Daguilarm\Belich\Http\Requests\ShowRequest;
use Daguilarm\Belich\Http\Requests\StoreRequest;
use Daguilarm\Belich\Http\Requests\UpdateRequest;
use Daguilarm\Belich\Core\Belich;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class CrudController extends Controller
{
    use Redirectable,
        Relationable;

    protected object $model;

    public function __construct(Belich $belich)
    {
        //Get resource model
        $this->model = $belich->getModel();
    }

    /**
     * List the resources.
     */
    public function index(Belich $belich, IndexRequest $request): View
    {
        //Authorization
        $this->authorize('viewAny', $this->model);
        //Get all the data
        $request = $request->data($belich, $request);

        return view('belich::dashboard.index', compact('request'));
    }

    /**
     * Create a new resource.
     */
    public function create(Belich $belich, CreateRequest $request): View
    {
        //Authorization
        $this->authorize('create', $this->model);
        //Get the data
        $request = $request->data($belich);

        return view('belich::dashboard.create', compact('request'));
    }

    /**
     * Store a new resource.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        //Authorization
        $this->authorize('create', $this->model);
        //Handle files
        $request = $request->handleFile();
        //Create file
        $create = $this->model::create(array_filter($request->all()));
        //Create relationships
        $this->createRelationship($create, array_filter($request->all()));

        return $this->redirectToAction($create, $actionSuccess = 'created', $actionFail = 'creating', $id = $create->id);
    }

    /**
     * Show the a resource.
     */
    public function show(Belich $belich, int $id, ShowRequest $request): View
    {
        //The autorization happend in Daguilarm\Belich\Fields\Abstracts\FieldResolve::authorizationFromPolicy()
        //Get the data
        $request = $request->data($belich, $id);

        return view('belich::dashboard.show', compact('request'));
    }

    /**
     * Edit a resource.
     */
    public function edit(Belich $belich, int $id, EditRequest $request): View
    {
        //The autorization happend in Daguilarm\Belich\Fields\Abstracts\FieldResolve::authorizationFromPolicy()
        //Get the data
        $request = $request->data($belich, $id);

        return view('belich::dashboard.edit', compact('request'));
    }

    /**
     * Update a resource.
     */
    public function update(UpdateRequest $request, int $id): RedirectResponse
    {
        //The autorization happend in Daguilarm\Belich\Fields\FieldValidate
        $model = $this->model->findOrFail($id);
        //Handle files
        $request = $request->handleFile($model);
        //Update files
        $update = $model->update(array_filter($request->all()));
        //Update relationships
        $this->updateRelationship($model, array_filter($request->all()));

        return $this->redirectToAction($update, $actionSuccess = 'updated', $actionFail = 'updating', $id);
    }

    /**
     * Delete a resource.
     */
    public function destroy(int $id): RedirectResponse
    {
        //Authorization
        $this->authorize('delete', $this->model);
        //Delete files
        $delete = $this->model->findOrFail($id)->delete();

        return $this->redirectToAction($delete, $actionSuccess = 'deleted', $actionFail = 'deleting', $id);
    }
}
