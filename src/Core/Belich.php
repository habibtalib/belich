<?php

namespace Daguilarm\Belich\Core;

use Daguilarm\Belich\Components\Blade;
use Daguilarm\Belich\Core\BelichRepository;
use Daguilarm\Belich\Core\Traits\Classable;
use Daguilarm\Belich\Core\Traits\Connectable;
use Daguilarm\Belich\Core\Traits\Modelable;
use Daguilarm\Belich\Core\Traits\Operationable;
use Daguilarm\Belich\Core\Traits\Resourceable;
use Daguilarm\Belich\Core\Traits\Routeable;
use Daguilarm\Belich\Core\Traits\Systemable;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class Belich extends BelichRepository
{
    use Classable, Connectable, Modelable, Operationable, Resourceable, Routeable, Systemable;

    /** @var string */
    private $request;

    /** @var string */
    private static $version = '1.0.1';

    /**
     * Init the constuctor
     */
    public function __construct()
    {
        $this->request = request();
        $this->user = \Illuminate\Support\Facades\Auth::user();

        //Set pagination
        if ($this->request->has('perPage')) {
            $this->perPage = $this->request->perPage;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Actions
    |--------------------------------------------------------------------------
    */

    /**
     * Prepare the actions for the view
     *
     * @param object $model
     * @param string $view
     *
     * @return Illuminate\View\View
     */
    public function actions(object $model, string $view): View
    {
        //Set view path
        $actionView = 'belich::actions.' . $view;

        return view()->exists($actionView)
            //Custom action
            ? view($actionView, ['model' => $model])
            //Default action
            : view('belich::actions.default', ['model' => $model]);
    }

    /*
    |--------------------------------------------------------------------------
    | Cards and Metrics
    |--------------------------------------------------------------------------
    */

    /**
     * Initialize the Cards and the Metrics
     *
     * @return string|null
     */
    public function components(Request $request): ?string
    {
        return (new Blade())->render($request);
    }
}
