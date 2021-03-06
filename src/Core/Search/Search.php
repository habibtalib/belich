<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Core\Search;

use Daguilarm\Belich\Facades\Belich;

final class Search
{
    /**
     * Get the resource search fields as array.
     */
    public static function get(): string
    {
        $class = Belich::resourceClassPath();

        //Stop search if the resource not exists
        if (! class_exists($class)) {
            return '';
        }

        //Get the search fields from the table
        $searchFields = $class::$search;

        //Defeault value: array
        $fields = self::getSearchFields($searchFields);

        return self::fieldsAsString($fields);
    }

    /**
     * Set if the request is from a live search
     */
    public static function searchRequest(): bool
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
     */
    public static function tableRequest(): array
    {
        $fields = explode(',', trim(request()->query('fields')));

        return collect($fields)->map(static function ($value) {
            return $value;
        })
            ->filter()
            ->toArray();
    }

    /**
     * Get the search fields
     */
    private static function getSearchFields(?array $fields): array
    {
        return is_array($fields)
          ? $fields
          : [];
    }

    /**
     * Return the search fields as string
     */
    private static function fieldsAsString(?array $fields): string
    {
        return count($fields) > 0
            ? collect($fields)->implode(',')
            : '';
    }
}
