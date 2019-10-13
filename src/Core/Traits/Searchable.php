<?php

namespace Daguilarm\Belich\Core\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Request;

trait Searchable {

    /*
    |--------------------------------------------------------------------------
    | Public Static Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Get the resource search fields as array.
     *
     * @return string
     */
    public static function searchFields() : string
    {
        $class = static::resourceClassPath();

        //Get the search fields from the table
        $searchFields = $class::$search;

        //Defeault value: array
        $fields = is_array($searchFields)
          ? $searchFields
          : [];

        return count($fields) > 0
            ? collect($fields)->implode(',')
            : '';
    }

    /**
     * Set if the request is from a live search
     *
     * @return string
     */
    public static function requestFromSearch() : bool
    {
        $request = request()->query();

        if(!empty($request['query'])
           && !empty($request['resourceName'])
           && is_string($request['resourceName'])
           && strlen($request['query']) >= config('belich.minSearch')
           && !empty($request['type'])
           && $request['type'] === 'search'
       ) {
            return true;
        }

        return false;
    }

    /**
     * Get the table fields for live search
     *
     * @return string
     */
    public static function requestTableFields() : array
    {
        $fields = explode(',', trim(request()->query('fields')));

        return collect($fields)->map(function($value) {
            return $value;
        })
        ->filter()
        ->toArray();
    }
}
