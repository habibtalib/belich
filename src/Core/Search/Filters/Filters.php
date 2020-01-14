<?php

namespace Daguilarm\Belich\Core\Search\Filters;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;
use Daguilarm\Belich\Core\Search\Search;
use Illuminate\Http\Request;

final class Filters implements HandleField
{
    /**
     * @var string|null
     */
    private $filters;

    /**
     * @var string
     */
    private $separator = '***';

    /**
     * Init constructor
     */
    public function __construct(?string $filters)
    {
        $this->filters = json_decode($filters);
    }

    /**
     * Resolve LiveSearch
     *
     * @param object $request
     * @param Closure $next
     *
     * @return object
     */
    public function handle(object $query, Closure $next): object
    {
        if ($this->filters) {
            // Get all the filters
            foreach($this->filters as $filter) {
                // Get the filter params
                $items = explode($this->separator, $filter);
                // Filter the query
                $query->when(count($items) === 3, static function ($query) use ($items) {
                    $query->where($items[1], '=', $items[2]);
                });
            };
        }

        return $next($query);
    }
}
