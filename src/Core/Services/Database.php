<?php

namespace Daguilarm\Belich\Core\Services;

use Daguilarm\Belich\Core\Services\Search;
use Daguilarm\Belich\Facades\Belich;
use Daguilarm\Belich\Facades\Helper;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

final class Database
{
    /**
     * Execute the Sql Connection
     *
     * @param string $class
     * @param Illuminate\Http\Request $request
     *
     * @return object
     */
    public function execute(object $class, Request $request): object
    {
        return Belich::action() === 'index'
            //Sql for index
            ? $this->indexQuery($class, $request)
            //Sql for edit and show
            : $this->crudQuery($class);
    }

    /**
     * Query for edit and show
     *
     * @param string $class
     *
     * @return object
     */
    private function crudQuery(object $class): object
    {
        //Sql for edit and show
        return Belich::action() === 'edit' || Belich::action() === 'show' && is_numeric(Belich::resourceId())
            ? $class->model()->findOrFail(Belich::resourceId())
            // Default value - empty results
            : new Collection();
    }

    /**
     * Eloquent query
     *
     * @param string $class
     * @param Illuminate\Http\Request $request
     *
     * @return object
     */
    private function indexQuery(object $class, Request $request): object
    {
        //Set variables
        [$direction, $order, $policy, $search, $model] = $this->filter($request);

        $results = $class
            //Add the current resource query
            ->indexQuery($request)
            //Live search
            ->when($search->searchRequest(), static function ($query) use ($request, $search) {
                //No results
                if ($request->query('query') === 'resetSearchAll') {
                    return $query;
                }
                //Get the results
                collect($search->tableRequest())->each(static function ($field) use ($query, $request): void {
                    $query->orWhere($field, 'LIKE', '%' . $request->query('query') . '%');
                });
            })
            //Order query
            ->when(isset($order) && isset($direction), static function ($query) use ($direction, $order): void {
                $query->orderBy($order, $direction);
            })
            //Show the trashed results
            ->when($policy && Helper::hasSoftdelete($model) && Cookie::get('belich_withTrashed') === 'all', static function ($query): void {
                $query->withTrashed();
            })
            //Only show the trashed results
            ->when($policy && Helper::hasSoftdelete($model) && Cookie::get('belich_withTrashed') === 'only', static function ($query): void {
                $query->onlyTrashed();
            });

        return config('belich.pagination') === 'simple'
            ? $results
                // Simple pagination
                ->simplePaginate(Cookie::get('belich_perPage'))
                //Add all the url variables
                ->appends($request->query())
            : $results
                // Regular link pagination
                ->paginate(Cookie::get('belich_perPage'))
                //Add all the url variables
                ->appends($request->query());
    }

    /**
     * Set variables
     *
     * @param Illuminate\Http\Request $request
     *
     * @return array
     */
    private function filter(Request $request): array
    {
        // Set values;
        $model = Belich::getModel();
        //Init search helper
        $search = app(Search::class);

        return [
            $request->query('direction'),
            $request->query('orderBy'),
            $request->user()->can('withTrashed', $model),
            $search,
            $model,
        ];
    }
}
