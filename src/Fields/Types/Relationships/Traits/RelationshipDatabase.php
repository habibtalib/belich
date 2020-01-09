<?php

namespace Daguilarm\Belich\Fields\Types\Relationships\Traits;

use Daguilarm\Belich\Facades\Helper;
use Illuminate\Support\Facades\Schema;

trait RelationshipDatabase
{
    /**
     * @var string
     */
    public $foreignKey;

    /**
     * @var callable
     */
    public $resolveQuery;

    /**
     * Get the Foreing key to connect the models
     *
     * @param string $key
     *
     * @return self
     */
    public function foreignKey(string $key): self
    {
        $this->foreignKey = $key;

        return $this;
    }

    public function query(\Closure $value): self
    {
        $this->resolveQuery = $value;

        return $this;
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

        return $this->foreignKey = Schema::hasColumn(Helper::stringPluralLower($this->resource), $column)
            ? $column
            : null;
    }

    /**
     * Populate relationship select
     *
     * @return array
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
