<?php

namespace Daguilarm\Belich\Fields;

use Daguilarm\Belich\Fields\Abstracts\RelationshipAbstract;

class Relationship extends RelationshipAbstract
{
    /**
     * Create a new relationship field
     *
     * @param  string  $label
     * @param  string  $resource [The relational resource in plural]
     * @param  string|null  $model [The relational model]
     *
     * @return  void
     */
    public function __construct(string $label, string $resource, ?string $model = null)
    {
        $this->resource = $this->getResource($resource);
        $this->label = $label ?? $this->resource;
        $this->model = $this->setModel($model);
    }

    /**
     * Set the field attributes
     *
     * @param  string|null  $attributes
     *
     * @return Daguilarm\Belich\Fields\Relationship
     */
    public static function make(...$attributes): Relationship
    {
        //Set the field values
        return new static(...$attributes);
    }

    /**
     * Get the Foreing key to connect the models
     *
     * @param string $key
     *
     * @return self
     */
    public static function foreignKey(string $key): self
    {
        $this->foreignKey = $key;

        return $this;
    }
}
