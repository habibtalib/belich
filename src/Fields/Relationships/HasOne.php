<?php

namespace Daguilarm\Belich\Fields\Relationships;

use Daguilarm\Belich\Contracts\RelationshipContract;
use Daguilarm\Belich\Facades\Helper;
use Daguilarm\Belich\Fields\Relationship;

class HasOne extends Relationship implements RelationshipContract
{
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
     * @param  object $field
     * @param  object $data
     *
     * @return string|null
     */
    public function index(object $field, ?object $data = null)
    {
        $result = $data->{$this->fieldRelationship}->{$this->table} ?? Helper::emptyResults();

        return sprintf('<a href="#" class="text-blue-500 font-bold hover:text-black">%s</a>', $result);
    }
}
