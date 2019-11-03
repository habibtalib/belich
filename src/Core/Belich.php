<?php

namespace Daguilarm\Belich\Core;

use Daguilarm\Belich\Components\Blade;
use Daguilarm\Belich\Core\BelichAbstract;
use Daguilarm\Belich\Core\Traits\Classable;
use Daguilarm\Belich\Core\Traits\Connectable;
use Daguilarm\Belich\Core\Traits\Modelable;
use Daguilarm\Belich\Core\Traits\Operationable;
use Daguilarm\Belich\Core\Traits\Resourceable;
use Daguilarm\Belich\Core\Traits\Routeable;
use Daguilarm\Belich\Core\Traits\Systemable;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class Belich extends BelichAbstract
{
    use Classable, Connectable, Modelable, Operationable, Resourceable, Routeable, Systemable;

    /** @var string */
    private $request;

    /** @var string */
    private $user;

    /** @var string */
    private static $version = '1.0.1';

    /**
     * Init the constuctor
     *
     * @return string
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

        //Custom action
        if (view()->exists($actionView)) {
            return view($actionView, ['model' => $model]);
        }

        //Default action
        return view('belich::actions.default', ['model' => $model]);
    }

    /*
    |--------------------------------------------------------------------------
    | Cards and Metrics
    |--------------------------------------------------------------------------
    */

    /**
     * Initialize the Cards and the Metrics
     *
     * @return null|string
     */
    public function components(Request $request): ?string
    {
        return (new Blade)->render($request);
    }
}
