<?php

namespace Daguilarm\Belich\Http\Controllers\Traits;

trait Relationable
{
    /**
     * Redirect back with message
     *
     * @param object $model
     * @param array $request
     *
     * @return
     */
    protected function updateRelationship(object $model, array $request): string
    {
        return $this->handleRelationship($model, $request, 'update');
    }

    /**
     * Redirect back with message
     *
     * @param object $model
     * @param array $request
     *
     * @return
     */
    protected function createRelationship(object $model, array $request): string
    {
        return $this->handleRelationship($model, $request, 'create');
    }

    /**
     * Handle relationship
     *
     * @param object $model
     * @param array $request
     * @param string $type
     *
     * @return
     */
    private function handleRelationship(object $model, array $request, string $type): string
    {
        return collect($request)
            ->each(static function ($value, $field) use ($model, $type): void {
                // Search for a relationship
                if (method_exists($model, $field) && is_array($value) && count($value) > 0) {
                    // Update the relationship
                    $model->{$field}()->{$type}($value);
                }
            });
    }
}
