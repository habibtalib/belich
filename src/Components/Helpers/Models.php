<?php

namespace Daguilarm\Belich\Components\Helpers;

trait Models
{
    /**
     * Set if the model has the trait softdelete
     *
     * @return bool
     */
    private function hasSoftdelete($model): bool
    {
        if (method_exists($model, 'trashed')) {
            return true;
        }

        return false;
    }

    /**
     * Set if the model has softdeleting results
     *
     * @return bool
     */
    private function hasSoftdeletedResults($model): bool
    {
        if (method_exists($model, 'trashed') && $model->trashed()) {
            return true;
        }

        return false;
    }

}
