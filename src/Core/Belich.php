<?php

namespace Daguilarm\Belich\Core;

use App\Belich\Navbar;
use App\Belich\Sidebar;
use Daguilarm\Belich\Components\Actions;
use Daguilarm\Belich\Components\Breadcrumbs;
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
     | Cards
     |--------------------------------------------------------------------------
     */

    /**
     * Initialize the Cards
     *
     * @return \Daguilarm\Belich\Core\Htm
     */
     public function cards(Request $request) : string
     {
        return collect($request->cards)
            ->map(function($card) {
                return $card::make()->render();
            })
            ->filter('')
            ->implode('');
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
       if(class_exists('\App\Belich\Navbar')) {
            return new Navbar($this->resourcesAll());
       }
       throw new \InvalidArgumentException('The \App\Belich\Navbar::class does not exist. Please restore the file to its folder or install the package again.');
    }

    /**
     * Prepare the sidebar for the view
     *
     * @return \App\Belich\Sidebar
     */
    public function sidebar()
    {
        if(class_exists('\App\Belich\Sidebar')) {
            return new Sidebar($this->resourcesAll());
        }
        throw new \InvalidArgumentException('The \App\Belich\Sidebar::class does not exist. Please restore the file to its folder or install the package again.');
    }
}
