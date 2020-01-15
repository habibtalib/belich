<?php

namespace Daguilarm\Belich\Core\Search\Filters\Operations;

use Closure;
use Daguilarm\Belich\Contracts\ConditionContract;
use Daguilarm\Belich\Contracts\HandleField;

final class GreaterOrMinorThan implements ConditionContract, HandleField
{
    /**
     * @var array
     */
    private $items;

    /**
     * @var string
     */
    private $operator;

    /**
     * @var array
     */
    private $value;

    /**
     * Init constructor
     */
    public function __construct(array $items, string $operator)
    {
        $this->items = $items;
        $this->operator = $operator;
        $this->value = explode($this->operator, $this->items[2]);
    }

    /**
     * Show trashed results
     *
     * @param object $query
     * @param Closure $next
     *
     * @return object
     */
    public function handle(object $query, Closure $next): object
    {
        // Filter the query
        $query->when($this->condition(), function ($query) {
            $query->where($this->items[1], $this->operator, $this->value[1]);
        });

        return $next($query);
    }

    /**
     * Resolve condition
     *
     * @return bool
     */
    public function condition(): bool
    {
        return isset($this->value[1]) && is_numeric($this->value[1]);
    }
}
