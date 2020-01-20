<?php

namespace Daguilarm\Belich\Core\Search\Filters;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;
use Daguilarm\Belich\Core\Search\Filters\Traits\Date;
use Daguilarm\Belich\Core\Search\Search;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

final class Filters implements HandleField
{
    use Date;

    /**
     * @var string|null
     */
    private $filters;

    /**
     * @var string
     */
    private $separator = '***';

    /**
     * Operations allowed
     *
     * @var array
     */
    private $allowed = ['date', 'equal', 'like', 'operations'];

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
     * @param object $query
     * @param Closure $next
     *
     * @return object
     */
    public function handle(object $query, Closure $next): object
    {
        collect($this->filters)
            ->each(function ($filter) use ($query) {
                $this->execute($query, $filter);
            });

        return $next($query);
    }

    /**
     * Execute all the operations
     *
     * @param object $query
     * @param string $filter
     */
    private function execute(object $query, string $filter)
    {
        // Get the filter params
        list($items, $filter) = $this->getParams($filter);

        // No filter
        if (! $filter) {
            return;
        }

        // If the method is allowed
        if (in_array($filter, $this->allowed)) {
            // Filter the query
            $this->{$filter}($query, $items);
        }
    }

    /**
     * Get the params...
     *
     * @param string $filter
     *
     * @return array
     */
    private function getParams(string $filter): array
    {
        $items = explode($this->separator, $filter);

        return [
            $items,
            $items[0],
        ];
    }

    /**
     * Equal filter
     *
     * @param object $query
     * @param array $items
     *
     * @return void
     */
    private function equal(object $query, array $items): void
    {
        // Filter the query
        $query->when(count($items) === 3, static function ($query) use ($items) {
            $query->where($items[1], '=', $items[2]);
        });
    }

    /**
     * Like filter
     *
     * @param object $query
     * @param array $items
     *
     * @return void
     */
    private function like(object $query, array $items): void
    {
        // Filter the query
        $query->when(count($items) === 3, static function ($query) use ($items) {
            $query->where($items[1], 'like', $items[2]);
        });
    }

    /**
     * Operations filter
     *
     * @param object $query
     * @param array $items
     *
     * @return void
     */
    private function operations(object $query, array $items): object
    {
        // Start the pipeline
        return app(Pipeline::class)
            ->send($query)
            ->through([
                new \Daguilarm\Belich\Core\Search\Filters\Operations\Intervals($items),
                new \Daguilarm\Belich\Core\Search\Filters\Operations\GreaterOrMinorThan($items, '>'),
                new \Daguilarm\Belich\Core\Search\Filters\Operations\GreaterOrMinorThan($items, '<'),
            ])
            ->thenReturn();
    }
}
