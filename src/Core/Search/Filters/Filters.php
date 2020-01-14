<?php

namespace Daguilarm\Belich\Core\Search\Filters;

use Carbon\Carbon;
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
                // If the method is allowed
                if (in_array($items[0], $this->allowed)) {
                    // Filter the query
                    $this->{$items[0]}($query, $items);
                }
            };
        }

        return $next($query);
    }

    /**
     * Equal filter
     *
     * @param object $query
     * @param array $items
     *
     * @return void
     */
    private function equal($query, $items): void
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
    private function like($query, $items): void
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
    private function operations($query, $items): void
    {
        // Get the operation and the values for Interval
        $this->operationsInterval($query, $items);

        // Get the operation and the values for Greater than...
        $this->operationsGreaterOrMinorThan($query, $items, '>');

        // Get the operation and the values for Minor than...
        $this->operationsGreaterOrMinorThan($query, $items, '<');

        // Get the operation and the values for date
        $this->date($query, $items);
    }

    /**
     * Operations filter
     *
     * @param object $query
     * @param array $items
     *
     * @return void
     */
    private function operationsInterval($query, $items): void
    {
        $interval = explode('-', $items[2]);
        $condition = isset($interval) && is_array($interval) && count($interval) === 2 && is_numeric($interval[0]) && is_numeric($interval[1]);

        // Filter the query
        $query->when($condition, static function ($query) use ($items, $interval) {
            $query->whereBetween($items[1], [$interval[0], $interval[1]]);
        });
    }

    /**
     * Operations filter: greater or minor than...
     *
     * @param object $query
     * @param array $items
     * @param string $operator ['<', '>']
     *
     * @return void
     */
    private function operationsGreaterOrMinorThan($query, $items, $operator): void
    {
        $value = explode($operator, $items[2]);
        $condition = isset($value[1]) && is_numeric($value[1]);

        // Filter the query
        $query->when($condition, static function ($query) use ($items, $operator, $value) {
            $query->where($items[1], $operator, $value[1]);
        });
    }

    /**
     * Date filter
     *
     * @param object $query
     * @param array $items
     * @param string $operator
     *
     * @return void
     */
    private function date($query, $items, $operator = 'now'): void
    {
        $date = explode('/', $items[2]);
        $condition = isset($date) && is_array($date) && isset($items[3]);

        if(isset($date[0]) && $date[0] === $operator) {
            // Filter the query
            $query->when($condition, static function ($query) use ($items, $date) {
                $query->whereBetween($items[1], [Carbon::today(), Carbon::createFromFormat($items[3], $date[1])]);
            });
        }

        if(isset($date[1]) && $date[1] === $operator) {
            // Filter the query
            $query->when($condition, static function ($query) use ($items, $date) {
                $query->whereBetween($items[1], [Carbon::createFromFormat($items[3], $date[0]), Carbon::today()]);
            });
        }
    }
}
