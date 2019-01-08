<?php

namespace Daguilarm\Belich\Constructor;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Belich {

    /**
     * Set the Request values
     *
     * @param Illuminate\Http\Request $request
     * @param string $action
     * @param int $id
     * @return Illuminate\Http\Request
     */
    public static function updateRequest(Request $request, string $action, int $id = 0) : Request
    {
        //Set default value
        $data = null;

        //List of resources from storage
        if($action === 'index') {
            $data = SELF::getResourceQueryBuilder($request);
        }

        //Get resource from storage
        if($action === 'show' || $action === 'update') {
            $data = '';
        }

        //Fill the request with the new data
        list($request['action'], $request['data'], $request['id'], $request['resource'], $request['resourceName'], $request['fields']) = [
            $action,
            $data,
            $id,
            SELF::getResource(),
            SELF::getResourceName(),
            SELF::getFields($request, $action),
        ];

        return $request;
    }

    /**
     * Get the resource name with lowercase and plural
     *
     * @return string
     */
    public static function getResource() : string
    {
        $resource = explode('/', request()->route()->uri);

        return $resource[1];
    }

    /**
     * Get the resource name with title case
     *
     * @return string
     */
    public static function getResourceName() : string
    {
        $titleCase = Str::title(SELF::getResource());

        return Str::singular($titleCase);
    }

    /**
     * Get the resource class
     *
     * @return object
     */
    public static function getResourceClass() : object
    {
        $class = sprintf('\\App\\Belich\\Resources\\%s', SELF::getResourceName());

        return app($class);
    }

    /**
     * Get the resource query from the \App\Belich\Resources\...
     *
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Database\Eloquent\Collection
     */
    public static function getResourceQueryBuilder(Request $request) : Collection
    {
        return SELF::getResourceClass()->indexQuery($request);
    }

    /**
     * Get the resource fields from the \App\Belich\Resources\...
     *
     * @return array
     */
    public static function getFields(Request $request, $action) : array
    {
        //Get all the fields from the Class
        $fields = SELF::getResourceClass()->fields($request);

        //Index case: Return only the name and the attribute for each field.
        if($action === 'index') {
            return collect($fields)->mapWithKeys(function($field, $key) {
                return [$field->name => $field->attribute];
            })
            ->all();
        }

        return $fields ?? [];
    }
}
