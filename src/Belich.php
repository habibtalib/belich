<?php

namespace Daguilarm\Belich;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Belich {

    /** @var string */
    private static $version = '1.0.0';

    /*
    |--------------------------------------------------------------------------
    | Application Getters
    |--------------------------------------------------------------------------
    */

    /**
     * Get the app name.
     *
     * @return string
     */
    public static function version() : string
    {
        return static::$version;
    }

    /**
     * Get the app name.
     *
     * @return string
     */
    public static function name() : string
    {
        return config('belich.name', 'Belich Dashboard');
    }

    /**
     * Get the app path.
     *
     * @return string
     */
    public static function path() : string
    {
        return config('belich.path', '/dashboard');
    }

    /**
     * Set the app url.
     *
     * @return string
     */
    public static function url() : string
    {
        return \Request::root() . static::path();
    }

    /**
     * Get route divided in arrays
     *
     * @return array
     */
    public static function route() : array
    {
        //Get route name
        return explode('.', \Request::route()->getName());
    }

    /**
     * Get route action ['index', 'edit', 'create' or 'show']
     *
     * @return string
     */
    public static function routeAction() : string
    {
        $route = self::route();

        //Return last item from the array
        return end($route);
    }

    /**
     * Get the route resource name ['users', 'billings',...]
     *
     * @return string
     */
    public static function routeResource() : string
    {
        $route = self::route();

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
        $resource = Str::singular(self::routeResource());

        return \Request::route($resource) ?? null;
    }

    /**
     * Get the current resource class: User
     *
     * @return string
     */
    public static function resourceClassName() : string
    {
        $className = Str::singular(self::routeResource());

        return Str::title($className);
    }

    /**
     * Get the current resource class path
     *
     * @return string
     */
    public static function resourceClass($className = null) : string
    {
        if($className) {
            $className = Str::title(Str::singular($className));
        }

        return '\\App\\Belich\\Resources\\' . ($className ?? self::resourceClassName());
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
    private static function initResourceClass($className = null) : object
    {
        $class = self::resourceClass($className);

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
    public static function resourcesAll() : Collection
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

                    return [$resource => self::getResourcesValue($className)];
                }
            });
    }

    /**
     * Get all the files from the resources folder
     *
     * @return Illuminate\Support\Collection
     */
    private static function getResourceFiles() : Collection
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
    private static function getResourcesValue($className)
    {
        $class = self::resourceClass($className);

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
     * Get the current a resource or (by default) the current resource
     *
     * @param string $resource
     * @return Illuminate\Support\Collection
     */
    public static function resource() : Collection
    {
        //Default values
        $class   = self::initResourceClass();
        $request = request();

        //Update the fields
        $updateFields = collect($class->fields($request));

        //Sql Response
        $sqlResponse = self::sqlResponse($class, $request);

        //Breadcrumbs
        $breadcrumbs = $class::$breadcrumbs;

        return collect([
            'name'             => self::routeResource(),
            'controllerAction' => self::routeAction(),
            'fields'           => \Daguilarm\Belich\Fields\FieldResolve::make($class, $updateFields, $sqlResponse),
            'results'          => self::sqlResponse($class, $request),
            'breadcrumbs'      => $breadcrumbs,
        ]);
    }

    /**
     * Create the belich admin
     *
     * @param string $class
     * @param Illuminate\Http\Request $request
     * @return object
     */
    private static function sqlResponse(object $class, \Illuminate\Http\Request $request) : object
    {
        if(self::routeAction() === 'index') {
            return $class->indexQuery($request);
        }

        if(self::routeAction() === 'edit' || self::routeAction() === 'show') {
            return $class->model()->findOrFail(self::routeId());
        }

        return new \Illuminate\Database\Eloquent\Collection;
    }
}
