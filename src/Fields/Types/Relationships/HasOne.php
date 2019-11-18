<?php

namespace Daguilarm\Belich\Fields\Types\Relationships;

use Daguilarm\Belich\Contracts\RelationshipContract;
use Daguilarm\Belich\Facades\Helper;
use Daguilarm\Belich\Fields\Relationship;

class HasOne extends Relationship implements RelationshipContract
{
    /**
     * @var string
     */
    public $subType = 'HasOne';

    /**
     * @var string
     */
    public $attribute;

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
        parent::__construct($label, $resource, $relationship);
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
        $value = optional($result)->{$this->table};
        $id = optional($result)->id;
        $url = sprintf('%s/%s/%s', config('belich.path'), $this->resources, $id);

        return $value
            ? view('belich::fields.HasOne.index', compact('value', 'url'))
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
        $field->options = $this->populateSelect();

        return view('belich::fields.select', ['field' => $field]);
    }

    /**
     * Populate relationship select
     *
     * @return array
     */
    private function populateSelect(): array
    {
        return $this->modelRelationship::select($this->table, 'id')
            ->pluck($this->table, 'id')
            ->toArray();
    }
}
