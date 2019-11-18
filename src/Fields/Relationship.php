<?php

namespace Daguilarm\Belich\Fields;

use Daguilarm\Belich\Facades\Belich;
use Daguilarm\Belich\Fields\Abstracts\Field as FieldAbstract;
use Daguilarm\Belich\Fields\Traits\Attributable;
use Daguilarm\Belich\Fields\Traits\Casteable;
use Daguilarm\Belich\Fields\Traits\Formatable;
use Daguilarm\Belich\Fields\Traits\Helpeable;
use Daguilarm\Belich\Fields\Traits\Relationable;
use Daguilarm\Belich\Fields\Traits\Ruleable;
use Daguilarm\Belich\Fields\Traits\Settingable;
use Daguilarm\Belich\Fields\Traits\Visibilitable;
use Illuminate\Support\Str;

class Relationship extends FieldAbstract
{
    use Attributable,
        Casteable,
        Formatable,
        Helpeable,
        Relationable,
        Ruleable,
        Settingable,
        Visibilitable;

    /**
     * Create a new relationship field
     *
     * @param  string  $label
     * @param  string  $resource [The relational resource in plural]
     * @param  string|null  $relationship [The relational model]
     *
     * @return  void
     */
    public function __construct(string $label, string $resource, ?string $relationship = null)
    {
        // Setup
        $this->resource = $this->getResource($resource);
        $this->resources = Str::plural($this->resource);
        $this->label = $label ?? $this->resource;
        $this->model = $this->createRelationshipModel($relationship);
        $this->fieldRelationship = $this->resource;
        $this->table = $this->getTable($this->table);

        // Resolve as html
        $this->asHtml();

        // Default visibility
        $this->showInAll();
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
    public function foreignKey(string $key): self
    {
        $this->foreignKey = $key;

        return $this;
    }

    /**
     * Get the table row
     *
     * @param string $table
     *
     * @return self
     */
    public function table(string $table): self
    {
        $this->table = $table;

        return $this;
    }
}
