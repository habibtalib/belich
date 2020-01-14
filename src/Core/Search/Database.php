<?php

namespace Daguilarm\Belich\Core\Search;

use Daguilarm\Belich\Core\Search\DatabaseCore;
use Daguilarm\Belich\Facades\Belich;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Cookie;

final class Database extends DatabaseCore
{
    /**
     * @var string
     */
    private $action;

    /**
     * @var string
     */
    private $withTrashed;

    /**
     * Init Constructor
     */
    public function __construct()
    {
        $this->action = Belich::action();
        $this->withTrashed = Cookie::get('belich_withTrashed');
    }

    /**
     * Handle the Sql Connection
     *
     * @param string $class
     * @param Illuminate\Http\Request $request
     *
     * @return object
     */
    public function handle(object $class, Request $request): object
    {
        return $this->action === 'index'
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
        return $this->action === 'edit' || $this->action === 'show' && is_numeric(Belich::resourceId())
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
        // Set variables
        [$direction, $order, $filters, $policy, $search, $model, $baseUrl, $urlQuery, $perPage, $paginateType] = $this->getVariables($request);
        $query = $class->indexQuery($request);

        // Start the pipeline
        $results = app(Pipeline::class)
            ->send($query)
            ->through([
                new \Daguilarm\Belich\Core\Search\Filters\LiveSearch($request, $search),
                new \Daguilarm\Belich\Core\Search\Filters\Filters($filters),
                new \Daguilarm\Belich\Core\Search\Filters\Order($direction, $request, $order),
                new \Daguilarm\Belich\Core\Search\Filters\Trashed($model, $request, $this->withTrashed, $policy),
                new \Daguilarm\Belich\Core\Search\Filters\OnlyTrashed($model, $request, $this->withTrashed, $policy),
            ])
            ->thenReturn();

        return $this->paginate($results, $paginateType, $perPage)
            //Add all the url variables
            ->appends($urlQuery)
            ->setPath($baseUrl);
    }
}
