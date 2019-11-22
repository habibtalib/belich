<?php

namespace Daguilarm\Belich\App\Http\Controllers\Traits;

use Symfony\Component\HttpFoundation\ParameterBag;

trait Relationable
{
    /**
     * Redirect back with message
     *
     * @param object $model
     * @param Symfony\Component\HttpFoundation\ParameterBag $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateRelationship(object $model, ParameterBag $request)
    {
        return collect($request)
            ->each(function ($value, $field) use ($model): void {
                // Search for a relationship
                if (method_exists($model , $field) && is_array($value) && count($value) > 0) {
                    // Update the relationship
                    $model->$field()->update($value);
                }
            });
    }
}
