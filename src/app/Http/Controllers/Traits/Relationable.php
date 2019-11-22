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
     * @return
     */
    protected function updateRelationship(object $model, ParameterBag $request)
    {
        return $this->handleRelationship($model, $request, 'update');
    }

    /**
     * Redirect back with message
     *
     * @param object $model
     * @param Symfony\Component\HttpFoundation\ParameterBag $request
     *
     * @return
     */
    protected function createRelationship(object $model, ParameterBag $request)
    {
        return $this->handleRelationship($model, $request, 'create');
    }

    /**
     * Handle relationship
     *
     * @param object $model
     * @param Symfony\Component\HttpFoundation\ParameterBag $request
     * @param string $type
     *
     * @return
     */
    private function handleRelationship(object $model, ParameterBag $request, string $type)
    {
        return collect($request)
            ->each(function ($value, $field) use ($model, $type): void {
                // Search for a relationship
                if (method_exists($model , $field) && is_array($value) && count($value) > 0) {
                    // Update the relationship
                    $model->{$field}()->{$type}($value);
                }
            });
    }
}
