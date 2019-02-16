<?php

namespace Daguilarm\Belich\Core;

use App\Belich\Navbar;
use App\Belich\Sidebar;
use Daguilarm\Belich\Components\Actions;
use Daguilarm\Belich\Components\Breadcrumbs;
use Daguilarm\Belich\Core\Helpers;
use Daguilarm\Belich\Core\Traits\SqlConnection;
use Illuminate\View\View;

class Belich {

    use Helpers, SqlConnection;

    /** @var string */
    private $perPage = 20;

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
    | Breadcrumbs
    |--------------------------------------------------------------------------
    */

   /**
    * Prepare the breadcrumbs for the view
    *
    * @param array $breadcrumbs
    * @return string
    */
    public function breadcrumbs(array $breadcrumbs)
    {
        return Breadcrumbs::make($breadcrumbs);
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
    public function html() : Html
    {
        return new \Daguilarm\Belich\Core\Html;
    }

    /*
    |--------------------------------------------------------------------------
    | Navbar and Sidebar
    |--------------------------------------------------------------------------
    */

   /**
    * Prepare the navbar for the view
    *
    * @return \App\Belich\Navbar
    */
    public function navbar()
    {
        return class_exists('\App\Belich\Navbar')
            ? new Navbar($this->resourcesAll())
            : abort(404, trans('belich::exceptions.no_class', ['class' => '\App\Belich\Navbar']));
    }

    /**
     * Prepare the sidebar for the view
     *
     * @return \App\Belich\Sidebar
     */
    public function sidebar()
    {
        return class_exists('\App\Belich\Sidebar')
            ? new Sidebar($this->resourcesAll())
            : abort(404, trans('belich::exceptions.no_class', ['class' => '\App\Belich\Sidebar']));
    }
}
