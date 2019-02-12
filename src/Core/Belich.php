<?php

namespace Daguilarm\Belich\Core;

use App\Belich\Navbar;
use Daguilarm\Belich\Components\Actions;
use Daguilarm\Belich\Components\Breadcrumbs;
use Daguilarm\Belich\Core\Helpers;
use Daguilarm\Belich\Fields\FieldResolve;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Belich {

    use Helpers;

    /** @var string */
    private static $version = '1.0.0';

    /** @var string */
    private $request;

    /** @var string */
    private $perPage = 20;

    /**
     * Init the constuctor
     *
     * @return string
     */
    public function __construct()
    {
        $this->request = request();

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
    public function currentResource() : Collection
    {
        //Default values
        $class = $this->initResourceClass();

        //Update the fields
        $updateFields = collect($class->fields($this->request));

        //Sql Response
        $sqlResponse = $this->sqlResponse($class, $this->request);

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
            'class'               => $className,
            'resource'            => Str::plural(Str::lower($className)),
            'displayInNavigation' => $class::$displayInNavigation,
            'group'               => $class::$group,
            'label'               => $class::$label ?? Str::title($className),
            'pluralLabel'         => $class::$pluralLabel ?? Str::plural(Str::title($className)),
            'breadcrumbs'         => $class::breadcrumbs(),
            'actions'             => $class::$actions,
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
                ->when(request()->query('order') && request()->query('direction'), function ($query) {
                    return $query->orderBy(request()->query('order'), request()->query('direction'));
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
    | Navbar and Sidebar
    |--------------------------------------------------------------------------
    */
    public function navbar()
    {
        return Navbar::make($this->resourcesAll());
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
}
