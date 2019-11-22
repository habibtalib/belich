<?php

namespace Daguilarm\Belich\Fields\Types\Relationships;

use Daguilarm\Belich\Contracts\RelationshipContract;
use Daguilarm\Belich\Facades\Helper;
use Daguilarm\Belich\Fields\Types\Relationship;
use Illuminate\Support\Str;

class HasOne extends Relationship implements RelationshipContract
{
    /**
     * @var string
     */
    public $subType = 'hasOne';

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
        parent::__construct($label, $resource, $relationship, $tableColumn);
    }

    /**
     * Resolve value for index
     *
     * @param  object $data
     *
     * @return string
     */
    public function index(?object $data = null): string
    {
        $result = optional($data)->{$this->fieldRelationship};
        $value = optional($result)->{$this->tableColumn};
        $id = optional($result)->id;
        $url = sprintf(
            '%s/%s/%s',
            config('belich.path'),
            Str::plural($this->resource),
            $id,
        );

        return $value
            ? view('belich::fields.' . $this->subType . '.index', compact('value', 'url'))
            : Helper::emptyResults();
    }

    /**
     * Resolve value for show
     *
     * @param  object $data
     *
     * @return string
     */
    public function show(?object $data = null): string
    {
        return $this->index($data);
    }

    /**
     * Resolve value for create
     *
     * @param  object $data
     *
     * @return string
     */
    public function create(object $field, ?object $data = null): string
    {
        // Searchable
        if ($this->searchable) {
            $field->responseArray = $this->getQuery();

            return view('belich::fields.autocomplete', ['field' => $field]);
        }

        // Select
        $field->options = $this->getQuery();

        return view('belich::fields.select', ['field' => $field]);
    }

    /**
     * Resolve value for edit
     *
     * @param  object $data
     *
     * @return string
     */
    public function edit(object $field, ?object $data = null): string
    {
        return $this->create($field, $data);
    }
}
