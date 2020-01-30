<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Core\Search\Filters\Operations;

use Closure;
use Daguilarm\Belich\Contracts\ConditionContract;
use Daguilarm\Belich\Contracts\HandleField;

final class GreaterOrMinorThan implements ConditionContract, HandleField
{
    private array $items;
    private string $operator;
    private array $value;

    public function __construct(array $items, string $operator)
    {
        $this->items = $items;
        $this->operator = $operator;
        $this->value = explode($this->operator, $this->items[2]);
    }

    /**
     * Show trashed results
     */
    public function handle(object $query, Closure $next): object
    {
        // Filter the query
        $query->when($this->condition(), function ($query): void {
            $query->where($this->items[1], $this->operator, $this->value[1]);
        });

        return $next($query);
    }

    /**
     * Resolve condition
     */
    public function condition(): bool
    {
        return isset($this->value[1]) && is_numeric($this->value[1]);
    }
}
