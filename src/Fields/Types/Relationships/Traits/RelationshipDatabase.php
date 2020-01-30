<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types\Relationships\Traits;

use Daguilarm\Belich\Facades\Helper;
use Illuminate\Support\Facades\Schema;

trait RelationshipDatabase
{
    public string $foreignKey;

    /**
     * @var callable
     */
    public $resolveQuery;

    /**
     * Get the Foreing key to connect the models
     */
    public function foreignKey(string $key): self
    {
        $this->foreignKey = $key;

        return $this;
    }

    /**
     * Custom query
     */
    public function query(\Closure $value): self
    {
        $this->resolveQuery = $value;

        return $this;
    }

    /**
     * Get the Foreing key from the resource (by default)
     */
    protected function getForeignKey(): ?string
    {
        if ($this->foreignKey) {
            return $this->foreignKey;
        }

        $column = sprintf('%s_id', Helper::stringSingularLower($this->resource));

        return $this->foreignKey = Schema::hasColumn(Helper::stringPluralLower($this->resource), $column)
            ? $column
            : null;
    }

    /**
     * Populate relationship select
     */
    protected function getQuery(): array
    {
        // Relationship class
        $relationshipClass = $this->getRelationshipClass($this->resource);

        // With callback
        if (isset($this->resolveQuery) && is_callable($this->resolveQuery)) {
            return call_user_func(
                $this->resolveQuery,
                new $relationshipClass::$model()
            );
        }

        return ['' => ''] + $relationshipClass
            ->indexQuery()
            ->select($this->tableColumn, 'id')
            ->pluck($this->tableColumn, 'id')
            ->toArray();
    }
}
