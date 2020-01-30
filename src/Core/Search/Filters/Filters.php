<?php

declare(strict_types=1);

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
     * @var string|array|null
     */
    private $filters;

    private string $separator = '***';
    private array $allowed = ['date', 'equal', 'like', 'operations'];

    public function __construct($filters)
    {
        $this->filters = $filters
            ? json_decode($filters)
            : '';
    }

    /**
     * Resolve LiveSearch
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
