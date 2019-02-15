<?php

namespace Daguilarm\Belich\Components\Navigation\Traits;

use Daguilarm\Belich\Facades\Belich;

trait Operations {
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
    public function getGroups()
    {
        return collect($this->resources)
            ->map(function ($item, $key) {
                return collect([
                    'hasGroup' => $item['group'] ? true : false,
                    'name'     => $item['group'] ?? $item['pluralLabel'] ?? stringPluralUpper($item['class']),
                    'resource' => $item['resource']
                ]);
            })
            ->filter()
            ->unique()
            ->values();
    }

    /**
     * Get all the resources from the project
     *
     * @return string
     */
    public function getSubgroups()
    {
         return collect($this->resources)
             ->map(function ($items) {
                 return $items->toArray();
             })
             ->values();
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
