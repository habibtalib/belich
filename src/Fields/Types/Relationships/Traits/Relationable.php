<?php

namespace Daguilarm\Belich\Fields\Types\Relationships\Traits;

use Daguilarm\Belich\Facades\Belich;
use Daguilarm\Belich\Facades\Helper;

trait Relationable
{
    /**
     * @var string
     */
    public $type = 'relationship';

    /**
     * @var string
     */
    public $label;

    /**
     * @var object
     */
    public $model;

    /**
     * @var object
     */
    public $perPageViaRelationship = 10;

    /**
     * @var string
     */
    public $minChars = 2;

    /**
     * @var string
     */
    public $resource;

    /**
     * @var array
     */
    public $responseArray;

    /**
     * @var array
     */
    public $responseUrl;

    /**
     * @var bool
     */
    public $searchable = false;

    /**
     * @var string
     */
    public $showValue;

    /**
     * Store as ID (Check autocomplete)
     *
     * @var string
     */
    public $store = 'id';

    /**
     * @var string
     */
    public $tableColumn;

    /**
     * Format/Set/Parse the current resource
     *
     * @param string $resource
     *
     * @return string
     */
    protected function getResource(string $resource): string
    {
        return Helper::stringSingularLower($resource);
    }

    /**
     *  Format/Set/Parse the current model
     *
     * @param string|null $model
     *
     * @return string
     */
    protected function getModelRelationship(?string $model = null): string
    {
        return Helper::stringSingularUpper($model ?? $this->resource);
    }

    /**
     *  Get the relationship resource class
     *
     * @param string $resource
     *
     * @return object
     */
    protected function getRelationshipClass(string $resource): object
    {
        $resourceClass = Belich::resourceClassPath($resource);

        return $this->relationshipClass = new $resourceClass();
    }

    /**
     *  Get the default attribute
     *
     * @param string $tableColumn
     *
     * @return string
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
     *
     * @param string $label
     * @param string $resource
     * @param string|null $tableColumn
     *
     * @return void
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