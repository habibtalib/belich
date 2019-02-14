<?php

namespace Daguilarm\Belich\Components\Navigation\Traits;

trait Operations {
    /*
    |--------------------------------------------------------------------------
    | Operations
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
}
