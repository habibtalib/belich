<?php

namespace Daguilarm\Belich\Components\Export;

use Daguilarm\Belich\Facades\Helper;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

final class Eloquent
{
    /**
     * Get collection from model
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public static function query(Request $request): Collection
    {
        // Get the model
        $model = static::model($request);

        // Download table columns
        $columns = $model->downloable ?? '*';

        //Selected fields
        if ($request->quantity === 'selected') {
            return $model
                ->select($columns)
                //App\Http\Helpers\Utils
                ->whereIn('id', Helper::fieldToArray($request->exports_selected))
                ->get();
        }

        //All the fields
        return $model
            ->select($columns)
            ->get();
    }

    /**
     * Get table name from model
     *
     * @param Illuminate\Http\Request $request
     *
     * @return string
     */
    public static function tableName(Request $request): string
    {
        return static::model($request)->getTable();
    }

    /**
     * Get the current model
     *
     * @param Illuminate\Http\Request $request
     *
     * @return object
     */
    private static function model(Request $request): object
    {
        return app($request->resource_model);
    }
}
