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
        //Get the resource class from App\Belich\Resources\...
        $resourceClass = SELF::getResourceClass();

        //List of resources from storage
        if($action === 'index') {
            $data = $resourceClass->indexQuery($request);

        //Get resource from storage
        } elseif($action === 'show' || $action === 'update' && $id > 0) {
            $data = $resourceClass->findOrFail($id);

        //Set default value
        } else {
            $data = collect([]);
        }

        //Fill the request with the new data
        list($request['action'], $request['data'], $request['id'], $request['resource'], $request['resourceName'], $request['fields']) = [
            $action,
            $data,
            $id,
            SELF::getResource(),
            SELF::getResourceName(),
            SELF::getFields($request, $action, $resourceClass),
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
     * Get the resource fields from the \App\Belich\Resources\...
     *
     * @param Illuminate\Http\Request $request
     * @param string $action
     * @param App\Belich\Resources $resourceClass
     * @return array
     */
    public static function getFields(Request $request, string $action, $resourceClass) : array
    {
        //Get all the fields from the Class
        $fields = $resourceClass->fields($request);

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
