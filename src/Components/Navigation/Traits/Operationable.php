<?php

namespace Daguilarm\Belich\Components\Navigation\Traits;

use Daguilarm\Belich\Facades\Belich;

trait Operationable {
    /*
    |--------------------------------------------------------------------------
    | Resources
    |--------------------------------------------------------------------------
    */
    /**
     * Get all the resources from the project
     *
     * @return string
     */
    public function getResources()
    {
        return collect($this->resources)
            ->map(function ($item, $key) {
                $title = $item['pluralLabel'] ?? stringPluralUpper($item['class']);
                if($item['displayInNavigation'] === true) {
                    return collect([
                        'group' => $item['group'] ?? $title,
                        'icon' => $item['icon'],
                        'name' => $title,
                        'resource' => $item['resource']
                    ]);
                }
            })
            ->filter()
            ->values()
            ->groupBy('group');
    }

    /*
    |--------------------------------------------------------------------------
    | Operations
    |--------------------------------------------------------------------------
    */

    /**
     * Merge arrays to string
     *
     * @param array $args
     * @return string
     */
    public function merge(...$args)
    {
        return implode(' ', $args);
    }

    /**
     * Set the url for a resource
     *
     * @param array $args
     * @return string
     */
    public function resourceUrl($resource)
    {
        return Belich::url() . '/' . $resource;
    }
}