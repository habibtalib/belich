<?php

namespace Daguilarm\Belich\Core;

use Daguilarm\Belich\Core\Helpers;
use Daguilarm\Belich\Core\Traits\Connectable;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class Belich {

    use Helpers, Connectable;

    /** @var string */
    private $request;

    /** @var string */
    private $user;

    /** @var string */
    private static $version = '1.0.0';

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
        if($this->request->has('perPage')) {
            $this->perPage = $this->request->perPage;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Init resource class
    |--------------------------------------------------------------------------
    */

    /**
     * Init the current class
     *
     * @return object
     */
    private function initResourceClass() : object
    {
        $class = static::resourceClassPath();

        return new $class;
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
    * @return Illuminate\View\View
    */
    public function actions(object $model, string $view) : View
    {
        //Set view path
        $actionView = 'belich::actions.' . $view;

        //Custom action
        if(view()->exists($actionView)) {
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
     * @return null|Blade
     */
     public function components(Request $request)
     {
        return (new \Daguilarm\Belich\Components\Blade)->render($request);
     }

    /*
    |--------------------------------------------------------------------------
    | Html helper
    |--------------------------------------------------------------------------
    */

   /**
    * Initialize the html helper in order to be accesible from Belich
    *
    * @return \Daguilarm\Belich\Core\Htm
    */
    public function html() : \Daguilarm\Belich\Core\Html
    {
        return new \Daguilarm\Belich\Core\Html;
    }
}
