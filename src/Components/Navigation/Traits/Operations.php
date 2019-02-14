<?php

namespace Daguilarm\Belich\Components\Navigation\Traits;

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
                 return $item['group'];
             })
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
    public function merge(...$args)
    {
        return implode(' ', $args);
    }

    /*
    |--------------------------------------------------------------------------
    | Css
    |--------------------------------------------------------------------------
    */
}
