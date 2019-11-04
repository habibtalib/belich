<?php

namespace Daguilarm\Belich\Components\Helpers;

trait Models
{
    /**
     * Set if the model has the trait softdelete
     *
     * @param string $model
     *
     * @return bool
     */
    private function hasSoftdelete(string $model): bool
    {
        return method_exists($model, 'trashed')
            ? true
            : false;
    }

    /**
     * Set if the model has softdeleting results
     *
     * @param string $model
     *
     * @return bool
     */
    private function hasSoftdeletedResults(string $model): bool
    {
        return method_exists($model, 'trashed') && $model->trashed()
            ? true
            : false;
    }

}
