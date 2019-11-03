<?php

namespace Daguilarm\Belich\App\Http\Controllers\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Deletedable
{
    /**
     * Sql query from soft deleted rows
     *
     * @param int $id
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    protected function whereDeletedID(int $id): Builder
    {
        return $this->model
            ->onlyTrashed()
            ->whereId($id);
    }
}
