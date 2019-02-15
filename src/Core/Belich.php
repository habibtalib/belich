<?php

namespace Daguilarm\Belich\Core;

use App\Belich\Navbar;
use App\Belich\Sidebar;
use Daguilarm\Belich\Components\Actions;
use Daguilarm\Belich\Components\Breadcrumbs;
use Daguilarm\Belich\Core\Helpers;
use Daguilarm\Belich\Fields\FieldResolve;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Daguilarm\Belich\Facades\Credentials;

class Belich {

    use Helpers;

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
    | Resources
    |--------------------------------------------------------------------------
    */

    /**
     * Get the current resource
     *
     * @return Illuminate\Support\Collection
     */
    public function currentResource(Request $request) : Collection
    {
        //Default values
        $class = $this->initResourceClass();

        //Update the fields
        $updateFields = collect($class->fields($request));

        //Sql Response
        $sqlResponse = $this->sqlResponse($class, $request);

        //ClassName
        $className = static::resource();

        return collect([
            'name'             => $className,
            'controllerAction' => static::action(),
            'fields'           => (new FieldResolve)->make($class, $updateFields, $sqlResponse),
            'results'          => $sqlResponse,
            'values'           => $this->resourceValues($className),//From resource
        ]);
    }

    /**
     * Get all the Belich resources for send globaly to the views
     *
     * @return Illuminate\Support\Collection
     */
    public function resourcesAll() : Collection
    {
        return $this->resourceFiles()
            ->map(function($file) {
                return $file;
            })->filter(function($value, $key) {
                return $value !== '.' && $value !== '..';
            })->mapWithKeys(function($file, $key) {
                if($file) {
                    //Define the current class name
                    $className = Str::title(explode('.', $file)[0]);
                    $resource  = Str::plural(Str::lower($className));

                    return [
                        $resource => $this->resourceValues($className)
                    ];
                }
            });
    }

    /**
     * Get all the files from the resources folder (All the resources)
     *
     * @return Illuminate\Support\Collection
     */
    private function resourceFiles() : Collection
    {
        $filePath = app_path('Belich/Resources');

        return collect(scandir($filePath));
    }

    /**
     * Get the labels for the current resource
     * Plural for the index and sigular for the others...
     *
     * @return string
     */
    private function resourceLabels() : string
    {
        $initializedClass = $this->initResourceClass();

        return (static::action() === 'index')
            ? $initializedClass::$pluralLabel
            : $initializedClass::$label;
    }

    /**
     * Get all the items from a resource
     *
     * @param string $className
     * @return array
     */
    private function resourceValues($className)
    {
        $class = static::resourceClassPath($className);

        return collect([
            'actions'             => $class::$actions,
            'breadcrumbs'         => $class::breadcrumbs(),
            'class'               => $className,
            'displayInNavigation' => $class::$displayInNavigation,
            'group'               => $class::$group,
            'icon'                => $class::$icon ?? 'angle-right',
            'label'               => $class::$label ?? Str::title($className),
            'model'               => $class::$model,
            'pluralLabel'         => $class::$pluralLabel ?? Str::plural(Str::title($className)),
            'resource'            => Str::plural(Str::lower($className)),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SQL
    |--------------------------------------------------------------------------
    */

    /**
    * Create the belich admin
    *
    * @param string $class
    * @param Illuminate\Http\Request $request
    * @return object
    */
    private function sqlResponse(object $class) : object
    {
        if(static::action() === 'index') {
            return $class
                ->indexQuery($this->request)
                //Order query
                ->when(request()->query('orderBy') && request()->query('direction'), function ($query) {
                    return $query->orderBy(request()->query('orderBy'), request()->query('direction'));
                })
                ->simplePaginate($this->perPage)
                //Add all the url variables
                ->appends(request()->query());
        }

        if(static::action() === 'edit' || static::action() === 'show' && is_numeric(static::resourceId())) {
            return $class
                ->model()
                ->findOrFail(static::resourceId());
        }

        return new \Illuminate\Database\Eloquent\Collection;
    }

    /*
    |--------------------------------------------------------------------------
    | Actions
    |--------------------------------------------------------------------------
    */
    public function actions($data, $view)
    {
        //Set view path
        $actionView = 'belich::actions.' . $view;

        //Custom action
        if(view()->exists($actionView)) {
            return view($actionView, ['data' => $data]);
        }

        //Default action
        return view('belich::actions.default', ['data' => $data]);
    }

    /*
    |--------------------------------------------------------------------------
    | Breadcrumbs
    |--------------------------------------------------------------------------
    */
    public function breadcrumbs($breadcrumbs)
    {
        return Breadcrumbs::make($breadcrumbs);
    }

    /*
    |--------------------------------------------------------------------------
    | Navbar and Sidebar
    |--------------------------------------------------------------------------
    */
    public function html()
    {
        return new \Daguilarm\Belich\Core\Html;
    }

    /*
    |--------------------------------------------------------------------------
    | Navbar and Sidebar
    |--------------------------------------------------------------------------
    */
    public function navbar()
    {
        return class_exists('\App\Belich\Navbar')
            ? new Navbar($this->resourcesAll())
            : abort(404, trans('belich::exceptions.no_class', ['class' => '\App\Belich\Navbar']));
    }

    public function sidebar()
    {
        return class_exists('\App\Belich\Sidebar')
            ? new Sidebar($this->resourcesAll())
            : abort(404, trans('belich::exceptions.no_class', ['class' => '\App\Belich\Sidebar']));
    }
}
