<?php

namespace Daguilarm\Belich\Fields\Traits;

use Daguilarm\Belich\Facades\Belich;
use Daguilarm\Belich\Facades\Helper;
use Illuminate\Support\Str;

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
    public $resource;

    /**
     * @var string
     */
    public $resolveIndex;

    /**
     * @var string
     */
    public $resolveShow;

    /**
     * @var string
     */
    public $resolveCreate;

    /**
     * @var string
     */
    public $resolveEdit;

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
        if (! $this->foreignKey) {
            $column = sprintf('%s_id', Helper::stringSingularLower($this->resource));

            return Schema::hasColumn(Helper::stringPluralLower($this->resource), $column)
                ? $column
                : null;
        }

        return $this->foreignKey;
    }

    /**
     * Create the relationship model (by default)
     *
     * @param string|null $model
     *
     * @return string|null
     */
    protected function createRelationshipModel(?string $model): ?string
    {
        $defaultRelationship = sprintf('%s\%s', config('belich.models'), $this->getModelRelationship());

        if (Str::endsWith($defaultRelationship, '\\')) {
            $defaultRelationship = str_replace('\\', '', $defaultRelationship);
        }

        return $model ?? $defaultRelationship ?? null;
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
     *  Get the default value for table
     *
     * @param string|null $table
     *
     * @return string
     */
    protected function getTable(?string $table): ?string
    {
        return $table ?? Belich::table() ?? null;
    }
}
