<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Core\Search\Filters\Operations;

use Closure;
use Daguilarm\Belich\Contracts\ConditionContract;
use Daguilarm\Belich\Contracts\HandleField;

final class Intervals implements ConditionContract, HandleField
{
    private array $items;
    private array $interval;

    public function __construct(array $items)
    {
        $this->items = $items;
        $this->interval = explode('-', $this->items[2]);
    }

    /**
     * Show trashed results
     */
    public function handle(object $query, Closure $next): object
    {
        // Filter the query
        $query->when($this->condition(), function ($query): void {
            $query->whereBetween($this->items[1], [$this->interval[0], $this->interval[1]]);
        });

        return $next($query);
    }

    /**
     * Resolve condition
     */
    public function condition(): bool
    {
        return isset($this->interval) && is_array($this->interval) && count($this->interval) === 2 && is_numeric($this->interval[0]) && is_numeric($this->interval[1]);
    }
}
