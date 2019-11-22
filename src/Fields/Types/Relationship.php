<?php

namespace Daguilarm\Belich\Fields\Types;

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
     * Relationship field can be editable
     *
     * @return self
     */
    public function editable(): self
    {
        $this->showInAll();

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
