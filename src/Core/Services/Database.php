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
     * @var array
     */
    private $allowedRequestQuery = [
        'orderBy',
        'direction',
        'page',
    ];

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
        [$direction, $order, $policy, $search, $model, $baseUrl, $query, $perPage, $paginateType] = $this->getVariables($request);

        $results = $class
            //Add the current resource query
            ->indexQuery($request)
            //Live search
            ->when($search->searchRequest(), function ($query) use ($request, $search) {
                return $this->liveSearch($query, $request, $search);
            })
            //Order query
            ->when(isset($order) && $order && isset($direction) && $direction, static function ($query) use ($direction, $order): void {
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

        return $this->paginate($results, $paginateType, $perPage)
            //Add all the url variables
            ->appends($query)
            ->setPath($baseUrl);
    }

    /**
     * Get variables
     *
     * @param Illuminate\Http\Request $request
     *
     * @return array
     */
    private function getVariables(Request $request): array
    {
        // Get model;
        $model = Belich::getModel();
        //Init search helper
        $search = app(Search::class);

        return [
            $request->query('direction'),
            $request->query('orderBy'),
            $request->user()->can('withTrashed', $model),
            $search,
            $model,
            $this->baseUrl(),
            [
                'direction' => $request->query('direction'),
                'orderBy' => $request->query('orderBy'),
                'page' => $request->query('page'),
                'DAM' => $request->query('DAM'),
            ],
            Cookie::get('belich_perPage'),
            config('belich.pagination'),
        ];
    }

    /**
     * Get the pagination url
     *
     * @return array
     */
    private function baseUrl(): string
    {
        return Belich::url() . '/' . Belich::resource() . '?uri=' . md5(Belich::resource());
    }

    /**
     * Get the pagination
     *
     * @param object $results
     * @param string $paginationType
     * @param string $perPage
     *
     * @return array
     */
    private function paginate($results, $paginateType, $perPage)
    {
        return $paginateType === 'simple'
            ? $results
                // Simple pagination
                ->simplePaginate($perPage)
            : $results
                // Regular link pagination
                ->paginate($perPage);
    }

    /**
     * Live search
     *
     * @param object $results
     * @param string $paginationType
     * @param string $perPage
     *
     * @return array
     */
    private function liveSearch($query, $request, $search)
    {
        //No results
        if ($request->query('query') === 'resetSearchAll') {
            return $query;
        }

        //Get the results
        collect($search->tableRequest())->each(static function ($field) use ($query, $request): void {
            $query->orWhere($field, 'LIKE', '%' . $request->query('query') . '%');
        });
    }
}
