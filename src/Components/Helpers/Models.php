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
        return method_exists($model, 'trashed')
            ? true
            : false;
    }

    /**
     * Set if the model has softdeleting results
     *
     * @return bool
     */
    private function hasSoftdeletedResults($model): bool
    {
        return method_exists($model, 'trashed') && $model->trashed()
            ? true
            : false;
    }

}
