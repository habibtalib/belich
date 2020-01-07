<?php

namespace Daguilarm\Belich\Core\Search;

use Daguilarm\Belich\Core\Search\Search;
use Daguilarm\Belich\Facades\Belich;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

abstract class DatabaseCore
{
    /**
     * @var array
     */
    protected $allowedRequestQuery = [
        'orderBy',
        'direction',
        'page',
    ];

    /**
     * Get variables
     *
     * @param Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function getVariables(Request $request): array
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
    protected function baseUrl(): string
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
    protected function paginate($results, $paginateType, $perPage)
    {
        return $paginateType === 'simple'
            ? $results
                // Simple pagination
                ->simplePaginate($perPage)
            : $results
                // Regular link pagination
                ->paginate($perPage);
    }
}
