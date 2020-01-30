<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types\Relationships;

use Daguilarm\Belich\Contracts\CustomFieldContract;
use Daguilarm\Belich\Contracts\FieldContract;
use Daguilarm\Belich\Contracts\RelationshipContract;
use Daguilarm\Belich\Fields\Types\Relationship;
use Daguilarm\Belich\Fields\Types\Relationships\Traits\Relationable;
use Daguilarm\Belich\Fields\Types\Relationships\Traits\RelationshipDatabase;
use Illuminate\Support\Str;

class HasOne extends Relationship implements CustomFieldContract, FieldContract, RelationshipContract
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
    public function index(object $field, ?object $data = null): ?object
    {
        // Get values
        $result = optional($data)->{$this->fieldRelationship};
        $value = optional($result)->{$this->tableColumn} ?? $this->noResults;
        $url = sprintf(
            '%s/%s/%s',
            config('belich.path'),
            Str::plural($this->resource),
            optional($result)->id
        );
        return view('belich::fields.hasOne.index', compact('value', 'url'));
    }

    /**
     * Resolve value for create
     */
    public function create(object $field, ?object $data = null): ?object
    {
        // Set values
        $field->type = 'text';
        $field->info = trans('belich::messages.relationships.new_field', ['value' => Str::plural($field->resource) ?? null]);

        return view('belich::fields.text', ['field' => $field]);
    }

    /**
     * Resolve value for edit
     */
    public function edit(object $field, ?object $data = null): ?object
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
    public function show(object $field, ?object $data = null): ?object
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
