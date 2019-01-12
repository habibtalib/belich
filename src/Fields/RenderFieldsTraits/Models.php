<?php

namespace Daguilarm\Belich\Fields\RenderFieldsTraits;

trait Models {

    /**
     * Set the model object
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    private function setModel()
    {
        if($this->action === 'index') {
            return $this->resourceClass->indexQuery($this->request);
        }

        if($this->action ==='show' || $this->action === 'edit' && $this->routeId > 0) {
            return $this->resourceClass->findOrFail($this->routeId);
        }
    }

    /**
     * Get relationship
     *
     * @return string
     */
    private function getRelationship($attribute)
    {
        return explode('.', $attribute);
    }

    /**
     * Get the array count from the relationship
     *
     * @return string
     */
    private function countRelationship($attribute)
    {
        return count(self::getRelationship($attribute)) ?? 1;
    }

    /**
     * Get relationship method
     *
     * @return string
     */
    private function getRelationshipMethod($attribute)
    {
        return self::getRelationship($attribute)[0] ?? $attribute;
    }

    /**
     * Get relationship attribute
     *
     * @return string
     */
    private function getRelationshipAttribute($attribute)
    {
        return self::getRelationship($attribute)[1] ?? $attribute;
    }
}
