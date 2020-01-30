<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types\Relationships;

use Daguilarm\Belich\Contracts\CrudContract;
use Daguilarm\Belich\Contracts\FieldContract;
use Daguilarm\Belich\Contracts\RelationshipContract;
use Daguilarm\Belich\Fields\Types\Relationship;
use Daguilarm\Belich\Fields\Types\Relationships\Traits\Relationable;
use Daguilarm\Belich\Fields\Types\Relationships\Traits\RelationshipDatabase;
use Illuminate\Support\Str;

class HasOne extends Relationship implements CrudContract, FieldContract, RelationshipContract
{
    use Relationable,
        RelationshipDatabase;

    public string $subType = 'hasOne';

    /**
     * Create a new relationship field
     */
    public function __construct(string $label, string $resource, ?string $tableColumn = null)
    {
        parent::__construct($label, $resource, $tableColumn);

        // Resolve as html
        $this->asHtml();

        // Show in all
        $this->showInAll();
    }

    /**
     * Resolve value for index
     */
    public function index(object $field, ?object $data = null): string
    {
        // Get values
        $result = optional($data)->{$this->fieldRelationship};
        $value = optional($result)->{$this->tableColumn};
        $url = sprintf(
            '%s/%s/%s',
            config('belich.path'),
            Str::plural($this->resource),
            optional($result)->id
        );

        return $value
            ? view('belich::fields.hasOne.index', compact('value', 'url'))
            : $this->noResults;
    }

    /**
     * Resolve value for create
     */
    public function create(object $field, ?object $data = null): ?string
    {
        // Set values
        $field->type = 'text';
        $field->info = trans('belich::messages.relationships.new_field', ['value' => Str::plural($field->resource) ?? null]);

        return view('belich::fields.text', ['field' => $field]);
    }

    /**
     * Resolve value for edit
     */
    public function edit(object $field, ?object $data = null): ?string
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
     * Resolve value for show
     */
    public function show(object $field, ?object $data = null): object
    {
        // Get values
        $value = optional($field)->value;
        $url = sprintf(
            '%s/%s/%s',
            config('belich.path'),
            Str::plural($this->resource),
            optional($field)->valueRelationship
        );
        // Set value
        $field->showValue = $value ? sprintf('<a href="%s" class="show-link">%s</a>', $url, $value) : $this->noResults;

        return $field;
    }
}
