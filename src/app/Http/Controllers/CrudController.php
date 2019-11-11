<?php

namespace Daguilarm\Belich\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Daguilarm\Belich\App\Http\Controllers\Traits\Redirectable;
use Daguilarm\Belich\App\Http\Requests\CreateRequest;
use Daguilarm\Belich\App\Http\Requests\EditRequest;
use Daguilarm\Belich\App\Http\Requests\IndexRequest;
use Daguilarm\Belich\App\Http\Requests\ShowRequest;
use Daguilarm\Belich\App\Http\Requests\StoreRequest;
use Daguilarm\Belich\App\Http\Requests\UpdateRequest;
use Daguilarm\Belich\Core\Belich;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class CrudController extends Controller
{
    use Redirectable;

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
     * List the resources.
     *
     * @param Daguilarm\Belich\Core\Belich $belich
     * @param Daguilarm\Belich\App\Http\Requests\IndexRequest $request
     *
     * @return Illuminate\View\View
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
     *
     * @param Daguilarm\Belich\Core\Belich $belich
     * @param Daguilarm\Belich\App\Http\Requests\CreateRequest $request
     *
     * @return Illuminate\View\View
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
     *
     * @param Illuminate\Http\StoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        //Authorization
        $this->authorize('create', $this->model);
        //Handle files
        $request = $request->handleFile();

        //Create file
        $create = $this->model::create(array_filter($request->all()));

        return $this->redirectToAction($create, $actionSuccess = 'created', $actionFail = 'creating', $id = $create->id);
    }

    /**
     * Show the a resource.
     *
     * @param Daguilarm\Belich\Core\Belich $belich
     * @param int $id
     * @param Daguilarm\Belich\App\Http\Requests\ShowRequest $request
     *
     * @return Illuminate\View\View
     */
    public function show(Belich $belich, int $id, ShowRequest $request): View
    {
        //Authorization
        $this->authorize('view', $this->model);
        //Get the data
        $request = $request->data($belich, $id);

        return view('belich::dashboard.show', compact('request'));
    }

    /**
     * Edit a resource.
     *
     * @param Daguilarm\Belich\Core\Belich $belich
     * @param int $id
     * @param Daguilarm\Belich\App\Http\Requests\EditRequest $request
     *
     * @return Illuminate\View\View
     */
    public function edit(Belich $belich, int $id, EditRequest $request): View
    {
        //The autorization happend in Daguilarm\Belich\Fields\FieldValidate
        //Get the data
        $request = $request->data($belich, $id);

        return view('belich::dashboard.edit', compact('request'));
    }

    /**
     * Update a resource.
     *
     * @param Illuminate\Http\UpdateRequest $request
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, int $id): RedirectResponse
    {
        //The autorization happend in Daguilarm\Belich\Fields\FieldValidate
        $model = $this->model->findOrFail($id);
        //Handle files
        $request = $request->handleFile($model);
        //Update files
        $update = $model->update(array_filter($request->all()));

        return $this->redirectToAction($update, $actionSuccess = 'updated', $actionFail = 'updating', $id);
    }

    /**
     * Delete a resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
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
