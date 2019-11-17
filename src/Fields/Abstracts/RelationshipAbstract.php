<?php

namespace Daguilarm\Belich\Fields\Abstracts;

use Daguilarm\Belich\Facades\Helper;
use Daguilarm\Belich\Fields\Traits\Visibilitable;
use Illuminate\Support\Str;

abstract class RelationshipAbstract
{
    use Visibilitable;

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
     * @var string
     */
    public $resource;

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
     * @param string $model
     *
     * @return string
     */
    protected function getModel(string $model): string
    {
        return Helper::stringSingularUpper($model);
    }

    /**
     * Get the Foreing key from the resource (by default)
     *
     * @return string|null
     */
    protected function setForeignKey(): ?string
    {
        $column = sprintf('%s_id', Helper::stringSingularLower($this->resource));

        return Schema::hasColumn(Helper::stringPluralLower($this->resource), $column)
            ? $column
            : null;
    }

    /**
     * Get the model from the resource (by default)
     *
     * @param string|null $model
     *
     * @return string|null
     */
    protected function setModel(?string $model): ?string
    {
        $defaultModel = sprintf('%s\%s', config('belich.models'), $this->getModel($this->resource));

        if(Str::endsWith($defaultModel, '\\')) {
            $defaultModel = str_replace('\\', '', $defaultModel);
        }

        return $model ?? $defaultModel ?? null;
    }
}
