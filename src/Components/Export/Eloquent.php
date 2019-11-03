<?php

namespace Daguilarm\Belich\Components\Export;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class Eloquent
{
    /**
     * Get collection from model
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public static function query(Request $request) : Collection
    {
        //Selected fields
        if($request->quantity === 'selected') {
            return static::model($request)
                //App\Http\Helpers\Utils
                ->whereIn('id', fieldToArray($request->exports_selected))
                ->get();
        }

        //All the fields
        return static::model($request)->all();
    }

    /**
     * Get table name from model
     *
     * @return string
     */
    public static function tableName(Request $request) : string
    {
        return static::model($request)->getTable();
    }

    /**
     * Get the current model
     *
     * @param Illuminate\Http\Request $request
     * @return object
     */
    private static function model(Request $request) : object
    {
        return app($request->resource_model);
    }
}
