<?php

namespace Daguilarm\Belich\Fields;

abstract class FieldBase
{
    /**
     * List of allowed controller actions
     *
     * @var array
     */
    public $allowedControllerActions = [
        'index',
        'create',
        'edit',
        'show',
    ];

    /**
     * The custom breadcrumbs for the field
     *
     * @var string
     */
    public $breadcrumbs;

    /**
     * The field relationship. Mostly for text fields wich want to show a relationship
     *
     * @var string
     */
    public $fieldRelationship;

    /**
     * Set the field label tag
     *
     * @var string
     */
    public $label;

    /**
     * Group by panel
     *
     * @var string
     */
    public $panel;

    /**
     * The model relationships
     *
     * @var string
     */
    public $relationships;

    /**
     * Table text align. Only on controller action: index
     *
     * @var string
     */
    public $tableTextAlign = 'left';

    /**
     * The field value (Resolved and updated...)
     *
     * @var string|null
     */
    public $value;

    /**
     * The field value for relationships (is the relation ID)
     *
     * @var string
     */
    public $valueRelationship;

    /**
     * Set the field attributes
     *
     * @param  string|null  $attributes
     *
     * @return Daguilarm\Belich\Fields\Field
     */
    abstract public static function make(...$attributes);

    /**
     * Group field into panels
     *
     * @param  string  $panel
     *
     * @return self
     */
    public function panels(string $panel): self
    {
        $this->panels = $panel;

        return $this;
    }
}
