<?php

namespace Daguilarm\Belich\Core\Search\Filters;

use Closure;
use Daguilarm\Belich\Contracts\ConditionContract;
use Daguilarm\Belich\Contracts\HandleField;
use Illuminate\Http\Request;

final class Order implements ConditionContract, HandleField
{
    /**
     * @var string|null
     */
    private $direction;

    /**
     * @var Illuminate\Http\Request
     */
    private $request;

    /**
     * @var string|null
     */
    private $order;

    /**
     * Init constructor
     */
    public function __construct(?string $direction, Request $request, ?string $order)
    {
        $this->direction = $direction;
        $this->request = $request;
        $this->order = $order;
    }

    /**
     * Query order
     *
     * @param object $query
     * @param Closure $next
     *
     * @return object
     */
    public function handle(object $query, Closure $next): object
    {
        $query = $query->when($this->condition(), function ($query): void {
            $query->orderBy($this->order, $this->direction);
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
        return isset($this->order) && $this->order && isset($this->direction) && $this->direction;
    }
}
