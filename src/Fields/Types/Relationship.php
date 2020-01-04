<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Facades\Belich;
use Daguilarm\Belich\Fields\FieldBase;
use Daguilarm\Belich\Fields\Traits\Attributable;
use Daguilarm\Belich\Fields\Traits\Casteable;
use Daguilarm\Belich\Fields\Traits\Conditionable;
use Daguilarm\Belich\Fields\Traits\Formatable;
use Daguilarm\Belich\Fields\Traits\Helpeable;
use Daguilarm\Belich\Fields\Traits\Relationable;
use Daguilarm\Belich\Fields\Traits\Renderable;
use Daguilarm\Belich\Fields\Traits\Ruleable;
use Daguilarm\Belich\Fields\Traits\Settingable;
use Daguilarm\Belich\Fields\Traits\Visibilitable;

class Relationship extends FieldBase
{
    use Attributable,
        Casteable,
        Conditionable,
        Formatable,
        Helpeable,
        Relationable,
        Renderable,
        Ruleable,
        Settingable,
        Visibilitable;

    /**
     * Set the relationship type
     *
     * @var bool
     */
    public $type = 'relationship';

    /**
     * The realtionship is not editable
     *
     * @var bool
     */
    public $editableRelationship = false;

    /**
     * Create a new relationship field
     *
     * @param  string  $label
     * @param  string  $resource [The relational resource in plural]
     * @param  string|null  $relationship [The relational model]
     * @param  string|null  $tableColumn [The relational table from the model]
     *
     * @return  void
     */
    public function __construct(string $label, string $resource, ?string $relationship = null, ?string $tableColumn = null)
    {
        // Default table
        $this->tableColumn = $tableColumn ?? Belich::tableColumn() ?? null;

        // Default values
        $this->getSetUp($label, $resource, $this->tableColumn);
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
     * Relationship field can be editable
     *
     * @return self
     */
    public function editable(): self
    {
        $this->editableRelationship = true;

        return $this;
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

    public function query(\Closure $value): self
    {
        $this->resolveQuery = $value;

        return $this;
    }

    /**
     * Show relationship as a searchable datalist
     *
     * @return self
     */
    public function searchable(): self
    {
        $this->searchable = true;

        return $this;
    }
}
