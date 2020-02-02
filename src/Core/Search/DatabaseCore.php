<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Core\Search;

use Daguilarm\Belich\Core\Search\Search;
use Daguilarm\Belich\Facades\Belich;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

abstract class DatabaseCore
{
    protected array $allowedRequestQuery = [
        'orderBy',
        'direction',
        'page',
        'filters',
    ];

    /**
     * Get variables
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
            $request->query('filters'),
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
            (int) Cookie::get('belich_perPage'),
            config('belich.pagination'),
        ];
    }

    /**
     * Get the pagination url
     */
    protected function baseUrl(): string
    {
        return Belich::url() . '/' . Belich::resource() . '?uri=' . md5(Belich::resource());
    }

    /**
     * Get the pagination
     */
    protected function paginate(object $results, string $paginateType, int $perPage): object
    {
        return $paginateType === 'simple'
            // Simple pagination
            ? $results->simplePaginate($perPage)
            // Regular link pagination
            : $results->paginate($perPage);
    }
}
