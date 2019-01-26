<?php

namespace Daguilarm\Belich;

use Daguilarm\Belich\Components\Breadcrumbs;
use Daguilarm\Belich\Fields\FieldResolve;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Belich {

    use Breadcrumbs;

    /** @var string */
    private static $version = '1.0.0';

    /** @var string */
    private $request;

    /**
     * Init the constuctor
     *
     * @return string
     */
    public function __construct()
    {
        $this->request = request();
    }

    /*
    |--------------------------------------------------------------------------
    | Static Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Get the app name.
     *
     * @return string
     */
    public function version() : string
    {
        return static::$version;
    }

    /*
    |--------------------------------------------------------------------------
    | Regular Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Get the app name.
     *
     * @return string
     */
    public function name() : string
    {
        return config('belich.name', 'Belich Dashboard');
    }

    /**
     * Get the app path.
     *
     * @return string
     */
    public function path() : string
    {
        return config('belich.path', '/dashboard');
    }

    /**
     * Set the app url.
     *
     * @return string
     */
    public function url() : string
    {
        return $this->request->root() . $this->path();
    }

    /**
     * Get route divided in arrays
     *
     * @return array
     */
    public function route() : array
    {
        $routeName = $this->request->route()->getName();

        //Get route name
        return explode('.', $routeName);
    }

    /**
     * Get route action ['index', 'edit', 'create' or 'show']
     *
     * @return string
     */
    public function routeAction() : string
    {
        $route = $this->route();

        //Return last item from the array
        return end($route);
    }

    /**
     * Get the route resource name ['users', 'billings',...]
     *
     * @return string
     */
    public function routeResource() : string
    {
        $route = $this->route();

        //Return last item from the array
        return $route[1];
    }

    /**
     * Get the route numeric id
     *
     * @return int
     */
    public static function routeId()
    {
        $resource = Str::singular($this->routeResource());

        return $this->request->route($resource) ?? null;
    }

    /**
     * Get the current resource class: User
     *
     * @return string
     */
    public function resourceClassName() : string
    {
        $className = Str::singular($this->routeResource());

        return Str::title($className);
    }

    /**
     * Get the current resource class path
     *
     * @return string
     */
    public function resourceClass($className = null) : string
    {
        if($className) {
            $className = Str::title(Str::singular($className));
        }

        return '\\App\\Belich\\Resources\\' . ($className ?? $this->resourceClassName());
    }

    /**
     * Get the current label for each controller action
     *
     * @return string
     */
    public function currentLabel($class) : string
    {
        $initializedClass = is_object($class)
            ? $class
            : $this->initResourceClass($class);

        return ($this->routeAction() === 'index')
            ? $initializedClass::$pluralLabel
            : $initializedClass::$label;
    }

    public function settings()
    {
        return collect([
            'controllerAction' => ''
        ]);
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
    private function initResourceClass($className = null) : object
    {
        $class = $this->resourceClass($className);

        return new $class;
    }

    /*
    |--------------------------------------------------------------------------
    | Get all the resources
    |--------------------------------------------------------------------------
    */

    /**
     * Get all the Belich resources for send globaly to the views
     *
     * @return Illuminate\Support\Collection
     */
    public function resourcesAll() : Collection
    {
        return self::getResourceFiles()
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
                        $resource => $this->getResourcesValue($className)
                    ];
                }
            });
    }

    /**
     * Get all the files from the resources folder
     *
     * @return Illuminate\Support\Collection
     */
    private function getResourceFiles() : Collection
    {
        $filePath = app_path('Belich/Resources');

        return collect(scandir($filePath));
    }

    /**
     * Get all the items from a resource
     *
     * @param string $className
     * @return array
     */
    private function getResourcesValue($className)
    {
        $class = $this->resourceClass($className);

        return collect([
            'class'               => $className,
            'key'                 => Str::plural(Str::lower($className)),
            'displayInNavigation' => $class::$displayInNavigation,
            'group'               => $class::$group,
            'label'               => $class::$label,
            'pluralLabel'         => $class::$pluralLabel,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Resource
    |--------------------------------------------------------------------------
    */

    /**
     * Get the current a resource
     *
     * @param bool $withSqlConection [Enable or disable the sql conection. When you need only the resource values and no the sql]
     * @return Illuminate\Support\Collection
     */
    public function resource($withSqlConection = true) : Collection
    {
        //Default values
        $class = $this->initResourceClass();

        //Update the fields
        $updateFields = collect($class->fields(request()));

        //Sql Response
        $sqlResponse = $withSqlConection
            ? $this->sqlResponse($class, request())
            : new \Illuminate\Database\Eloquent\Collection;

        return collect([
            'name'             => $this->routeResource(),
            'controllerAction' => $this->routeAction(),
            'fields'           => FieldResolve::make($class, $this->routeAction(), $updateFields, $sqlResponse),
            'results'          => $sqlResponse,
            'breadcrumbs'      => collect([]),
            //'breadcrumbs'      => $this->filterBreadcrumbs($class),
        ]);
    }

    /**
     * Create the belich admin
     *
     * @param string $class
     * @param Illuminate\Http\Request $request
     * @return object
     */
    private function sqlResponse(object $class) : object
    {
        if($this->routeAction() === 'index') {
            return $class->indexQuery($this->request);
        }

        if($this->routeAction() === 'edit' || $this->routeAction() === 'show') {
            return $class->model()->findOrFail($this->routeId());
        }

        return new \Illuminate\Database\Eloquent\Collection;
    }

    /*
    |--------------------------------------------------------------------------
    | Navbar and Sidebar
    |--------------------------------------------------------------------------
    */
    public function navbar() {
        return (new \App\Belich\Navbar)::make($this->resourcesAll());
    }
}
