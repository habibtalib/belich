<?php

namespace Daguilarm\Belich\Core\Traits;

use Daguilarm\Belich\Core\Services\Database;
use Daguilarm\Belich\Core\Services\Search;
use Daguilarm\Belich\Fields\Resolves\Authorization;
use Daguilarm\Belich\Fields\Resolves\Render;
use Daguilarm\Belich\Fields\Resolves\Resolve;
use Daguilarm\Belich\Fields\Resolves\ResolveCrudValue;
use Daguilarm\Belich\Fields\Resolves\Visible;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait Resourceable
{
    /**
     * Get all the Belich resources for send globaly to the views
     *
     * @return Illuminate\Support\Collection
     */
    public function allResources(): Collection
    {
        return $this->folderResources()
            ->map(static function ($file) {
                return $file;
            })->filter(static function ($value) {
                return $value !== '.' && $value !== '..';
            })->mapWithKeys(function ($file) {
                //Define the current class name
                $className = Str::title(explode('.', $file)[0]);
                $resource = Str::plural(Str::lower($className));

                return [
                    $resource => $this->valueResources($className, $forNavigation = true),
                ];
            });
    }

    /**
     * Get the current resource
     *
     * @return Illuminate\Support\Collection
     */
    public function currentResource(Request $request): Collection
    {
        // Default values
        $class = $this->initResourceClass($request);
        // Update the fields
        $updateFields = collect($class->fields($request));
        // Sql Response
        $sql = app(Database::class)->execute($class, $request);
        // ClassName
        $className = static::resource();
        // Resolve and built
        $builder = new Resolve(
            new Authorization(),
            new Render(),
            new ResolveCrudValue(),
            new Visible()
        );

        return collect([
            'name' => $className,
            'controllerAction' => static::action(),
            'fields' => $builder->execute($updateFields, $sql),
            'results' => $sql,
            'values' => $this->valueResources($className),
        ]);
    }

    /**
     * Get all the resources grouped and prepare for navigation
     *
     * @return Illuminate\Support\Collection
     */
    public function groupResources(): Collection
    {
        return collect($this->allResources())
            ->map(static function ($item) {
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
    private function folderResources(): Collection
    {
        $filePath = app_path('Belich/Resources');

        return collect(scandir($filePath));
    }

    /**
     * Get all the items from a resource
     *
     * @param string|null $className
     * @param bool $forNavigation [only return the parameters needed for navigation]
     *
     * @return Illuminate\Support\Collection
     */
    private function valueResources(?string $className, bool $forNavigation = false): Collection
    {
        //Get class name from request or from live search
        $className = app(Search::class)->searchRequest()
            ? static::className()
            : $className;
        //Get the class path
        $class = static::resourceClassPath($className);
        //Set values
        [$accessToResource, $displayInNavigation] = self::configurationResources($class);
        //Set the basic values for navigation
        $resource = self::getNavigationFields($class, $className, $displayInNavigation);

        //Navigation values
        return $forNavigation === false
            ? self::getAdvanceFields($class, $accessToResource, $resource)
            : $resource;
    }

    /**
     * Helper for basic resource (for navigation). Get only the basic resources.
     *
     * @param string $className
     * @param bool $forNavigation [only return the parameters needed for navigation]
     * @param string $class
     *
     * @return Illuminate\Support\Collection
     */
    private function getNavigationFields(string $class, string $className, bool $displayInNavigation): Collection
    {
        return collect([
            'class' => $className,
            'displayInNavigation' => $displayInNavigation,
            'group' => $class::$group,
            'icon' => $class::$icon ?? config('belich.navbar.defaultIcon') ?? '',
            'label' => $class::$label ?? Str::title($className),
            'pluralLabel' => $class::$pluralLabel ?? Str::plural(Str::title($className)),
            'resource' => Str::plural(Str::lower($className)),
            'search' => $class::$search,
            'tableTextAlign' => self::tableTextAlign($class),
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
    private function getAdvanceFields(string $class, string $accessToResource, Collection $resource): Collection
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
     * Helper for configurate a resource
     *
     * @param string $className
     *
     * @return Illuminate\Support\Collection
     */
    private function configurationResources(string $class)
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
     * Used by getResourceOnlyWithNavigationFields() in Core\Traits\Resourceable
     *
     * @param string $class
     *
     * @return string
     */
    private function tableTextAlign(string $class): string
    {
        //Get the resource value
        $align = $class::$tableTextAlign ?? null;

        //Validate the value
        return in_array($align, ['left', 'center', 'right', 'justify'])
            ? 'text-' . $align
            : 'text-left';
    }
}
