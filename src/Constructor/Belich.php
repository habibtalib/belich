<?php

namespace Daguilarm\Belich\Constructor;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Belich {

    public static function getResource() : string
    {
        $resource = explode('/', request()->route()->uri);

        return $resource[1];
    }

    public static function getResourceName() : string
    {
        $UpperName = Str::upper(SELF::getResource());

        return Str::singular($UpperName);
    }

    public static function getResourceClass() : object
    {
        $class = sprintf('\\App\\Belich\\Resources\\%s', SELF::getResourceName());

        return app($class);
    }

    public static function getResourceQueryBuilder(Request $request) : Collection
    {
        return SELF::getResourceClass()->indexQuery($request);
    }

    public static function getFields(Request $request)
    {
        $fields = SELF::getResourceClass()->fields($request);

        if($request->action === 'index') {
            return collect($fields)->mapWithKeys(function($field, $key) {
                return [$field->name => $field->attribute];
            })
            ->all();
        }
    }
}
