<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types\Relationships\Traits;

use Daguilarm\Belich\Facades\Belich;
use Daguilarm\Belich\Facades\Helper;

trait Relationable
{
    public object $model;
    public int $perPageViaRelationship = 10;
    public int $minChars = 2;
    public string $resource;
    public array $responseArray = [];
    public string $responseUrl;
    public bool $searchable = false;
    public string $showValue;
    public string $store = 'id';
    public string $tableColumn;

    /**
     * Format/Set/Parse the current resource
     */
    protected function getResource(string $resource): string
    {
        return Helper::stringSingularLower($resource);
    }

    /**
     *  Format/Set/Parse the current model
     */
    protected function getModelRelationship(?string $model = null): string
    {
        return Helper::stringSingularUpper($model ?? $this->resource);
    }

    /**
     *  Get the relationship resource class
     */
    protected function getRelationshipClass(string $resource): object
    {
        $resourceClass = Belich::resourceClassPath($resource);

        return $this->relationshipClass = new $resourceClass();
    }

    /**
     *  Get the default attribute
     */
    protected function getRelationAttribute(string $tableColumn): string
    {
        return sprintf(
            '%s[%s]',
            strtolower($this->resource),
            $tableColumn
        );
    }

    /**
     *  Get the default values for variables
     */
    protected function getSetUp(string $label, string $resource, ?string $tableColumn): void
    {
        // Setup
        $this->resource = $this->getResource($resource);
        $this->label = $label ?? $this->resource;
        $this->fieldRelationship = $this->resource;

        // Multiple assignment
        $this->attribute = $this->id = $this->dusk = $tableColumn;
        $this->name = $this->getRelationAttribute($tableColumn);
    }
}
