<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Facades\Belich;
use Daguilarm\Belich\Facades\Helper;
use Daguilarm\Belich\Fields\FieldBase;
use Daguilarm\Belich\Fields\Traits\Attributable;
use Daguilarm\Belich\Fields\Traits\Casteable;
use Daguilarm\Belich\Fields\Traits\Conditionable;
use Daguilarm\Belich\Fields\Traits\Formatable;
use Daguilarm\Belich\Fields\Traits\Helpeable;
use Daguilarm\Belich\Fields\Traits\Renderable;
use Daguilarm\Belich\Fields\Traits\Ruleable;
use Daguilarm\Belich\Fields\Traits\Settingable;
use Daguilarm\Belich\Fields\Traits\Visibilitable;

abstract class Relationship extends FieldBase
{
    use Attributable,
        Casteable,
        Conditionable,
        Formatable,
        Helpeable,
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
     * Set the no results default
     *
     * @var string
     */
    public $noResults;

    /**
     * Create a new relationship field
     *
     * @param  string  $label
     * @param  string  $resource [The relational resource in plural]
     * @param  string|null  $tableColumn [The relational table from the model]
     *
     * @return  void
     */
    public function __construct(string $label, string $resource, ?string $tableColumn = null)
    {
        // Default table
        $this->tableColumn = $tableColumn ?? Belich::tableColumn() ?? null;

        // Default values
        $this->getSetUp($label, $resource, $this->tableColumn);

        // No results
        $this->noResults = Helper::emptyResults();
    }

    /**
     * Populate relationship select
     *
     * @return array
     */
    abstract protected function getQuery(): array;

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
