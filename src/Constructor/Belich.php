<?php

namespace Daguilarm\Belich\Constructor;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Belich {

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
    public static function getFields(Request $request) : array
    {
        //Get all the fields from the Class
        $fields = SELF::getResourceClass()->fields($request);

        //Index case: Return only the name and the attribute for each field.
        if($request->action === 'index') {
            return collect($fields)->mapWithKeys(function($field, $key) {
                return [$field->name => $field->attribute];
            })
            ->all();
        }
    }
}
