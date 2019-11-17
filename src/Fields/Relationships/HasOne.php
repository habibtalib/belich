<?php

namespace Daguilarm\Belich\Fields\Relationships;

use Daguilarm\Belich\Contracts\RelationshipContract;
use Daguilarm\Belich\Fields\Relationship;

class HasOne extends Relationship implements RelationshipContract
{
    /**
     * @var string
     */
    public $typeRelation = 'HasOne';
}
