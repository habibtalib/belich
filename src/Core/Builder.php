<?php

namespace Daguilarm\Belich\Core;

use Daguilarm\Belich\Components\Breadcrumbs;
use Daguilarm\Belich\Core\Helpers;
use Daguilarm\Belich\Fields\FieldResolve;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Builder {

    use Breadcrumbs;

    /**
     * Access to the static methods from Helper
     *
     * @param  string $method
     * @param  array $parameters
     *
     * @return Boolean
     */
    public function __call($method, $parameters)
    {
        if(method_exists(Helpers::class, $method)) {
            return Helpers::$method();
        }
    }

    /** @var string */
    private $request;

    /**
     * Init the constuctor
     *
     * @return string
     */
    public function __construct()
    {
        $this->request = new Request;
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
        $class = Helpers::resourceClassPath();

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
     * @param bool $withSqlConection [Enable or disable the sql conection. When you need only the resource values and no the sql]
     * @return Illuminate\Support\Collection
     */
    public function resource($withSqlConection = true) : Collection
    {
        //Default values
        $class = $this->initResourceClass();

        //Update the fields
        $updateFields = collect($class->fields($this->request));

        //Sql Response
        $sqlResponse = $withSqlConection
            ? $this->sqlResponse($class, $this->request)
            : new \Illuminate\Database\Eloquent\Collection;

        return collect([
            'name'             => Helpers::resource(),
            'controllerAction' => Helpers::action(),
            'fields'           => (new FieldResolve)->make($class, $updateFields, $sqlResponse),
            'results'          => $sqlResponse,
            'breadcrumbs'      => collect([]),
            //'breadcrumbs'      => $this->filterBreadcrumbs($class),
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

        return (Helpers::action() === 'index')
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
        $class = Helpers::resourceClassPath($className);

        return collect([
            'class'               => $className,
            'resource'            => Str::plural(Str::lower($className)),
            'displayInNavigation' => $class::$displayInNavigation,
            'group'               => $class::$group,
            'label'               => $class::$label,
            'pluralLabel'         => $class::$pluralLabel,
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
        if(Helpers::action() === 'index') {
            return $class
                ->indexQuery($this->request);
        }

        if(Helpers::action() === 'edit' || Helpers::action() === 'show' && is_numeric(Helpers::resourceId())) {
            return $class
                ->model()
                ->findOrFail(Helpers::resourceId());
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
