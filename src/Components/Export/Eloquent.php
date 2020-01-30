<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Components\Export;

use Daguilarm\Belich\Facades\Helper;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

final class Eloquent
{
    /**
     * Get collection from model
     */
    public static function query(Request $request): Collection
    {
        // Get the model
        $model = static::model($request);

        //Selected fields
        if ($request->quantity === 'selected') {
            return $model
                ->select(static::columns($model))
                //App\Http\Helpers\Utils
                ->whereIn('id', Helper::fieldToArray($request->exports_selected))
                ->get();
        }

        //All the fields
        return $model
            ->select(static::columns($model))
            ->get();
    }

    /**
     * Get table name from model
     */
    public static function tableName(Request $request): string
    {
        return static::model($request)->getTable();
    }

    /**
     * Get the current model
     */
    private static function model(Request $request): object
    {
        return app($request->resource_model);
    }

    /**
     * Get the columns from the model
     */
    private static function columns(object $model): array
    {
        return method_exists($model, 'download') && is_array($model->download())
            ? $model->download() ?? ['*']
            : ['*'];
    }
}
