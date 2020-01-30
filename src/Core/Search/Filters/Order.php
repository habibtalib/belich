<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Core\Search\Filters;

use Closure;
use Daguilarm\Belich\Contracts\ConditionContract;
use Daguilarm\Belich\Contracts\HandleField;
use Illuminate\Http\Request;

final class Order implements ConditionContract, HandleField
{
    /**
     * @var Illuminate\Http\Request
     */
    private $request;

    private ?string $direction;
    private ?string $order;

    public function __construct(?string $direction, Request $request, ?string $order)
    {
        $this->direction = $direction;
        $this->request = $request;
        $this->order = $order;
    }

    /**
     * Query order
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
     */
    public function condition(): bool
    {
        return isset($this->order) && $this->order && isset($this->direction) && $this->direction;
    }
}
