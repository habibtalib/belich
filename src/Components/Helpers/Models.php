<?php

namespace Daguilarm\Belich\Components\Helpers;

trait Models
{
    /**
     * Set if the model has the trait softdelete
     *
     * @param object $model
     *
     * @return bool
     */
    public function hasSoftdelete(object $model): bool
    {
        return method_exists($model, 'bootSoftDeletes');
    }

    /**
     * Set if the model has softdeleting results
     *
     * @param string $model
     *
     * @return bool
     */
    public function hasSoftdeletedResults(string $model): bool
    {
        return method_exists($model, 'trashed') && $model->trashed();
    }
}
