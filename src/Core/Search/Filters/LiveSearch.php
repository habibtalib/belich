<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Core\Search\Filters;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;
use Daguilarm\Belich\Core\Search\Search;
use Illuminate\Http\Request;

final class LiveSearch implements HandleField
{
    /**
     * @var Illuminate\Http\Request
     */
    private $request;

    /**
     * @var Daguilarm\Belich\Core\Search\Search
     */
    private $search;

    public function __construct(Request $request, Search $search)
    {
        $this->request = $request;
        $this->search = $search;
    }

    /**
     * Resolve LiveSearch
     */
    public function handle(object $query, Closure $next): object
    {
        //No results
        if ($this->request->query('query') === 'resetSearchAll') {
            return $next($query);
        }

        //Live search
        $query = $query->when($this->search->searchRequest(), function ($query) {
            return $this->liveSearch($query, $this->search);
        });

        return $next($query);
    }

    /**
     * Live search
     */
    private function liveSearch(object $query, object $search)
    {
        //Get the results
        return $query->where(function ($query) use ($search): void {
            // All the search params from the Resource
            collect($search->tableRequest())
                ->each(function ($field) use ($query): void {
                    $query->orWhere($field, 'LIKE', '%' . $this->request->query('query') . '%');
                });
        });
    }
}
