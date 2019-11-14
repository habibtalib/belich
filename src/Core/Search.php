<?php

namespace Daguilarm\Belich\Core;

final class Search
{
    /**
     * Get the resource search fields as array.
     *
     * @return string
     */
    public static function searchFields(): string
    {
        $class = Belich::resourceClassPath();

        //Stop search if the resource not exists
        if (! class_exists($class)) {
            return '';
        }

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
    public static function requestFromSearch(): bool
    {
        $request = request()->query();

        if (isset($request['query'])
           && isset($request['resourceName'])
           && is_string($request['resourceName'])
           && strlen($request['query']) >= config('belich.minSearch')
           && isset($request['type'])
           && $request['type'] === 'search'
        ) {
            return true;
        }
        return false;
    }

    /**
     * Get the table fields for live search
     *
     * @return array
     */
    public static function requestTableFields(): array
    {
        $fields = explode(',', trim(request()->query('fields')));

        return collect($fields)->map(static function ($value) {
            return $value;
        })
            ->filter()
            ->toArray();
    }
}
