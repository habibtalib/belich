<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields;

abstract class FieldBase
{
    /**
     * The field value (Resolved and updated...)
     *
     * @var string|int|float|null
     */
    public $value;

    public array $allowedControllerActions = [
        'index',
        'create',
        'edit',
        'show',
    ];
    public string $breadcrumbs;
    public string $fieldRelationship = '';
    public string $label;
    public string $panel;
    public array $relationships = [];
    public string $tableTextAlign = 'left';
    public string $valueRelationship = '';

    /**
     * Set the field attributes
     */
    abstract public static function make(...$attributes);

    /**
     * Group field into panels
     */
    public function panels(string $panel): self
    {
        $this->panels = $panel;

        return $this;
    }
}
