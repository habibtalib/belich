<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Http\Controllers\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Deletedable
{
    /**
     * Sql query from soft deleted rows
     */
    protected function whereDeletedID(int $id): Builder
    {
        return $this->model
            ->onlyTrashed()
            ->whereId($id);
    }
}
