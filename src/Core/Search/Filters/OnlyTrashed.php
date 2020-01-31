<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Core\Search\Filters;

use Closure;
use Daguilarm\Belich\Contracts\ConditionContract;
use Daguilarm\Belich\Contracts\HandleField;
use Daguilarm\Belich\Facades\Helper;
use Illuminate\Http\Request;

final class OnlyTrashed implements ConditionContract, HandleField
{
    /**
     * @var Illuminate\Http\Request
     */
    private $request;

    private object $model;
    private ?string $trashed;
    private bool $policy;

    public function __construct(object $model, Request $request, ?string $trashed, bool $policy)
    {
        $this->model = $model;
        $this->request = $request;
        $this->trashed = $trashed;
        $this->policy = $policy;
    }

    /**
     * Show trashed results
     */
    public function handle(object $query, Closure $next): object
    {
        $query = $query->when($this->condition(), static function ($query): void {
            $query->onlyTrashed();
        });

        return $next($query);
    }

    /**
     * Resolve condition
     */
    public function condition(): bool
    {
        return $this->policy && Helper::hasSoftdelete($this->model) && $this->trashed === 'only';
    }
}
