<?php

namespace Daguilarm\Belich\Core\Traits;

use Daguilarm\Belich\Fields\FieldResolve;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait Resourceable {

    /*
    |--------------------------------------------------------------------------
    | Public Static Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Get the resource name ['users', 'billings',...]
     *
     * @return string
     */
    public static function resource() : string
    {
        //Return middle item from the array
        return static::route()[1];
    }

    /**
     * Get the current resource class path
     *
     * @return string
     */
    public static function resourceClassPath($className = null) : string
    {
        if($className) {
            $className = Str::title(Str::singular($className));
        }

        return '\\App\\Belich\\Resources\\' . ($className ?? static::resourceName());
    }

    /**
     * Get the current resource class name: User
     *
     * @return string
     */
    public static function resourceName() : string
    {
        $className = Str::singular(static::resource());

        return Str::title($className);
    }

    /**
     * Get the resource id
     *
     * @return int
     */
    public static function resourceId()
    {
        $resource   = Str::singular(static::resource());
        $resourceId = request()->route($resource) ?? null;

        if(is_null($resourceId)) {
            return null;
        }

        if(is_numeric($resourceId)) {
            return $resourceId;
        }

        throw new \InvalidArgumentException('The resource ID is invalid.');
    }

    /**
     * Get the resource url.
     *
     * @return string
     */
    public static function resourceUrl() : string
    {
        return static::url() . '/' . static::resource();
    }

    /*
    |--------------------------------------------------------------------------
    | Resource Operations
    |--------------------------------------------------------------------------
    */

    /**
     * Get the resource $downloable variable.
     *
     * @return string
     */
    public static function downloable() : string
    {
        $class = static::resourceClassPath();

        return $class::$downloable;
    }

    /**
     * Get the resource $tabs variable.
     *
     * @return string
     */
    public static function tabs() : string
    {
        $class = static::resourceClassPath();

        return $class::$tabs;
    }

    /**
     * Get the resource $redirectTo variable.
     *
     * @return string
     */
    public static function redirectTo() : string
    {
        $class = static::resourceClassPath();

        return $class::$redirectTo;
    }

    /**
     * Get the resource $accessToResource variable.
     *
     * @return bool
     */
    public static function accessToResource() : bool
    {
        $class = static::resourceClassPath();

        // This is for the views (like dashboard)
        // which has not a resouce class
        // so don't ever remove!
        if(class_exists($class)) {
            return $class::$accessToResource;
        }

        return true;
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
        $sqlResponse = $this->SqlConnectionResponse($class, $request);

        //ClassName
        $className = static::resource();

        return collect([
            'name'             => $className,
            'controllerAction' => static::action(),
            'fields'           => (new FieldResolve)->make($class, $updateFields, $sqlResponse),
            'results'          => $sqlResponse,
            'values'           => $this->resourceValues($className),
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
                        $resource => $this->resourceValues($className, $forNavigation = true)
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
     * @param bool $forNavigation [only return the parameters needed for navigation]
     * @return array
     */
    private function resourceValues($className, $forNavigation = false)
    {
        $class = static::resourceClassPath($className);

        //If a resource is not accessible then cannot be listed in a menu
        if($class::$accessToResource === false) {
            $accessToResource = $displayInNavigation = false;

        //Default values
        } else {
            $accessToResource    = $class::$accessToResource;
            $displayInNavigation = $class::$displayInNavigation;
        }

        //Set the basic values for navigation
        $resource = collect([
            'class'                 => $className,
            'displayInNavigation'   => $displayInNavigation,
            'group'                 => $class::$group,
            'icon'                  => $class::$icon ?? 'angle-right',
            'label'                 => $class::$label ?? Str::title($className),
            'pluralLabel'           => $class::$pluralLabel ?? Str::plural(Str::title($className)),
            'resource'              => Str::plural(Str::lower($className)),
        ]);

        //Advanced values
        if($forNavigation === false) {
            return $resource->merge([
                'accessToResource'    => $accessToResource,
                'actions'             => $class::$actions,
                'breadcrumbs'         => $class::breadcrumbs(),
                'cards'               => $class::cards(request()),
                'model'               => $class::$model,
                'metrics'             => $class::metrics(request()),
            ]);
        }

        //Navigation values
        return $resource;
    }
}
