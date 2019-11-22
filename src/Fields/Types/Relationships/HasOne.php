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
     * Relationships can be editables
     *
     * @var string
     */
    public $editable;

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

        // Resolve as html
        $this->asHtml();
        // Editable relationships disabled by default
        $this->exceptOnForms();
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
        // Get values
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
     * @param  object $field
     * @param  object|null $data
     *
     * @return object
     */
    public function show(object $field, ?object $data = null): object
    {
        // Get values
        $value = optional($field)->value;
        $url = sprintf(
            '%s/%s/%s',
            config('belich.path'),
            Str::plural($this->resource),
            optional($field)->valueRelationship,
        );
        // Set value
        $field->showValue = $value ? sprintf('<a href="%s" class="show-link">%s</a>', $url, $value) : Helper::emptyResults();

        return $field;
    }

    /**
     * Resolve value for create
     *
     * @param  object $data
     *
     * @return string|null
     */
    public function create(object $field, ?object $data = null): ?string
    {
        // Set values
        $field->type = 'text';
        $field->help = trans('belich::messages.relationships.new_field', ['value' => Str::plural($field->resource) ?? null]);

        return view('belich::fields.text', ['field' => $field]);
    }

    /**
     * Resolve value for edit
     *
     * @param  object $data
     *
     * @return string|null
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
}
