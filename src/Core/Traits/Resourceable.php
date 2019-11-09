<?php

namespace Daguilarm\Belich\Core\Traits;

use Daguilarm\Belich\Core\Database;
use Daguilarm\Belich\Core\Search;
use Daguilarm\Belich\Facades\Helper;
use Daguilarm\Belich\Fields\FieldResolve;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait Resourceable
{
    /**
     * Get the resource name ['users', 'billings',...]
     *
     * @return string
     */
    public static function resource(): string
    {
        return app(Search::class)->requestFromSearch()
            //Search action
            ? Helper::stringPluralLower(request()->query('resourceName'))
            //Return middle item from the array
            : static::route()[1] ?? '';
    }

    /**
     * Get the current resource class path
     *
     * @param string|null $className
     *
     * @return string
     */
    public static function resourceClassPath(?string $className = null): string
    {
        $class = $className ?? static::className();

        return '\\App\\Belich\\Resources\\' . static::classFormat($class);
    }

    /**
     * Get the current resource class name: User
     *
     * @return string
     */
    public static function resourceName(): string
    {
        $className = Str::singular(static::resource());

        return Str::title($className);
    }

    /**
     * Get the resource id
     *
     * @return int|null
     */
    public static function resourceId(): ?int
    {
        $resource = Str::singular(static::resource());
        $resourceId = request()->route($resource) ?? null;

        if (is_null($resourceId)) {
            return null;
        }

        if (is_numeric($resourceId)) {
            return $resourceId;
        }

        throw new \InvalidArgumentException(trans('belich::exceptions.invalid.resourceId'));
    }

    /**
     * Get the resource url.
     *
     * @return string
     */
    public static function resourceUrl(): string
    {
        return static::url() . '/' . static::resource();
    }

    /**
     * Get the resource $downloable variable.
     *
     * @return string
     */
    public static function downloable(): string
    {
        $class = static::resourceClassPath();

        return $class::$downloable;
    }

    /**
     * Get the resource $tabs variable.
     *
     * @return bool
     */
    public static function tabs(): bool
    {
        $class = static::resourceClassPath();

        return $class::$tabs ?? false;
    }

    /**
     * Get the resource $redirectTo variable.
     *
     * @return string
     */
    public static function redirectTo(): string
    {
        $class = static::resourceClassPath();

        return $class::$redirectTo;
    }

    /**
     * Get the resource $accessToResource variable.
     *
     * @return bool
     */
    public static function accessToResource(): bool
    {
        $class = static::resourceClassPath();

        return class_exists($class)
            // This is for the views (like dashboard)
            // which has not a resouce class
            // so don't ever remove!
            ? $class::$accessToResource
            : true;
    }

    /**
     * Get the current resource
     *
     * @return Illuminate\Support\Collection
     */
    public function currentResource(Request $request): Collection
    {
        //Default values
        $class = $this->initResourceClass($request);

        //Update the fields
        $updateFields = collect($class->fields($request));

        //Sql Response
        $sqlResponse = app(Database::class)->response($class, $request);

        //ClassName
        $className = static::resource();

        return collect([
            'name' => $className,
            'controllerAction' => static::action(),
            'fields' => app(FieldResolve::class)->make($class, $updateFields, $sqlResponse),
            'results' => $sqlResponse,
            'values' => $this->resourceValues($className),
        ]);
    }

    /**
     * Get all the Belich resources for send globaly to the views
     *
     * @return Illuminate\Support\Collection
     */
    public function resourcesAll(): Collection
    {
        return $this->resourceFiles()
            ->map(static function ($file) {
                return $file;
            })->filter(static function ($value, $key) {
                return $value !== '.' && $value !== '..';
            })->mapWithKeys(function ($file, $key) {
                //Define the current class name
                $className = Str::title(explode('.', $file)[0]);
                $resource = Str::plural(Str::lower($className));

                return [
                    $resource => $this->resourceValues($className, $forNavigation = true),
                ];
            });
    }

    /**
     * Get all the resources grouped and prepare for navigation
     *
     * @return Illuminate\Support\Collection
     */
    public function getGroupResources(): Collection
    {
        return collect($this->resourcesAll())
            ->map(static function ($item, $key) {
                $title = $item['pluralLabel'] ?? stringPluralUpper($item['class']);
                $resources = collect([
                    'group' => $item['group'] ?? $title,
                    'icon' => $item['icon'],
                    'name' => $title,
                    'resource' => $item['resource'],
                ]);

                return $item['displayInNavigation'] === true
                    ? $resources
                    : null;
            })
            ->filter()
            ->values()
            ->groupBy('group');
    }

    /**
     * Get all the files from the resources folder (All the resources)
     *
     * @return Illuminate\Support\Collection
     */
    private function resourceFiles(): Collection
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
    private function resourceLabels(): string
    {
        $initializedClass = $this->initResourceClass(request());

        return static::action() === 'index'
            ? $initializedClass::$pluralLabel
            : $initializedClass::$label;
    }

    /**
     * Get all the items from a resource
     *
     * @param string|null $className
     * @param bool $forNavigation [only return the parameters needed for navigation]
     *
     * @return Illuminate\Support\Collection
     */
    private function resourceValues(?string $className, bool $forNavigation = false): Collection
    {
        //Get class name from request or from live search
        $className = app(Search::class)->requestFromSearch()
            ? static::className()
            : $className;

        //Get the class path
        $class = static::resourceClassPath($className);

        //Set values
        [$accessToResource, $displayInNavigation] = self::resourceConfiguration($class);

        //Set the basic values for navigation
        $resource = self::getResourceOnlyWithNavigationFields($class, $className, $displayInNavigation);

        //Navigation values
        return $forNavigation === false
            ? self::getResourceWithAdvanceFields($class, $accessToResource, $resource)
            : $resource;
    }

    /**
     * Helper for basic resource (for navigation)
     *
     * @param string $className
     * @param bool $forNavigation [only return the parameters needed for navigation]
     * @param string $class
     *
     * @return Illuminate\Support\Collection
     */
    private function getResourceOnlyWithNavigationFields(string $class, string $className, bool $displayInNavigation): Collection
    {
        return collect([
            'class' => $className,
            'displayInNavigation' => $displayInNavigation,
            'group' => $class::$group,
            'icon' => $class::$icon ?? 'angle-right',
            'label' => $class::$label ?? Str::title($className),
            'pluralLabel' => $class::$pluralLabel ?? Str::plural(Str::title($className)),
            'resource' => Str::plural(Str::lower($className)),
            'search' => $class::$search,
            'tableTextAlign' => self::setTableTextAlign($class),
        ]);
    }

    /**
     * Helper for advanced resource
     *
     * @param string $className
     * @param string $accessToResource
     * @param Illuminate\Support\Collection $resource
     *
     * @return Illuminate\Support\Collection
     */
    private function getResourceWithAdvanceFields(string $class, string $accessToResource, Collection $resource): Collection
    {
        return $resource->merge([
            'accessToResource' => $accessToResource,
            'actions' => $class::$actions,
            'breadcrumbs' => $class::breadcrumbs(),
            'cards' => $class::cards(request()),
            'model' => $class::$model,
            'metrics' => $class::metrics(request()),
            'search' => $class::$search,
        ]);
    }

    /**
     * Helper for configuration
     *
     * @param string $className
     *
     * @return Illuminate\Support\Collection
     */
    private function resourceConfiguration(string $class)
    {
        //If a resource is not accessible then cannot be listed in a menu
        $accessToResource = $displayInNavigation = false;

        //Default values
        if ($class::$accessToResource === true) {
            $accessToResource = $class::$accessToResource;
            $displayInNavigation = $class::$displayInNavigation;
        }

        return [
            $accessToResource,
            $displayInNavigation,
        ];
    }

    /**
     * Set the table text align
     *
     * @param string $class
     *
     * @return string
     */
    private function setTableTextAlign(string $class): string
    {
        //Get the resource value
        $align = $class::$tableTextAlign ?? null;

        //Validate the value
        return in_array($align, ['left', 'center', 'right', 'justify'])
            ? 'text-' . $align
            : 'text-left';
    }
}
