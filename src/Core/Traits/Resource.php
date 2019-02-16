<?php

namespace Daguilarm\Belich\Core\Traits;

use Daguilarm\Belich\Fields\FieldResolve;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait Resource {

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
        $resourceId = Request::route($resource) ?? null;

        if(is_null($resourceId)) {
            return null;
        }

        if(is_numeric($resourceId)) {
            return $resourceId;
        }

        return abort(404);
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
}
