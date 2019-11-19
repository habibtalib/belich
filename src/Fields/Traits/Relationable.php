<?php

namespace Daguilarm\Belich\Fields\Traits;

use Daguilarm\Belich\Facades\Belich;
use Daguilarm\Belich\Facades\Helper;
use Illuminate\Support\Facades\Schema;

trait Relationable
{
    /**
     * @var string
     */
    public $type = 'relationship';

    /**
     * @var string
     */
    public $foreignKey;

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
     * This is for regular fields. In this case has to be empty.
     *
     * @var string|null
     */
    public $fieldRelationship;

    /**
     * @var string
     */
    public $minChars = 2;

    /**
     * @var string
     */
    public $resource;

    /**
     * @var object
     */
    public $relationshipClass;

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
     * Store as ID (Check autocomplete)
     *
     * @var string
     */
    public $store = 'id';

    /**
     * @var string
     */
    public $table;

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
     * Get the Foreing key from the resource (by default)
     *
     * @return string|null
     */
    protected function getForeignKey(): ?string
    {
        if ($this->foreignKey) {
            return $this->foreignKey;
        }

        $column = sprintf('%s_id', Helper::stringSingularLower($this->resource));

        return Schema::hasColumn(Helper::stringPluralLower($this->resource), $column)
            ? $column
            : null;
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
     *  Get the default value for table in the current Resource
     *
     * @return string
     */
    protected function getTable(): ?string
    {
        return $table ?? Belich::table() ?? null;
    }

    /**
     *  Get the default attribute
     *
     * @return string
     */
    protected function getRelationAttribute(): string
    {
        return sprintf(
            '%s.%s',
            strtolower($this->resource),
            $this->getTable(),
        );
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

        return new $resourceClass();
    }

    /**
     * Populate relationship select
     *
     * @return array
     */
    protected function getQuery(): array
    {
        return $this->relationshipClass
            ->indexQuery()
            ->select($this->table, 'id')
            ->pluck($this->table, 'id')
            ->toArray();
    }

    /**
     *  Get the default values for variables
     *
     * @param string $label
     * @param string $resource
     *
     * @return void
     */
    protected function getSetUp(string $label, string $resource): void
    {
        // Get relationship resource class
        $this->relationshipClass = $this->getRelationshipClass($resource);

        // Setup
        $this->resource = $this->getResource($resource);
        $this->label = $label ?? $this->resource;
        $this->fieldRelationship = $this->resource;

        // Multiple assignment
        $this->attribute = $this->getTable();
        $this->id = $this->getRelationAttribute();
        $this->name = $this->getRelationAttribute();
        $this->dusk = $this->getRelationAttribute();
    }
}
