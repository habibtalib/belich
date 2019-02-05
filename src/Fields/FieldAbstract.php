<?php

namespace Daguilarm\Belich\Fields;

abstract class FieldAbstract {

    /** @var array [List of allowed controller actions] */
    private $allowedControllerActions = [
        'index',
        'create',
        'edit',
        'show'
    ];

    /** @var string [The attribute / column name of the field] */
    public $attribute;

    /** @var string [The custom breadcrumbs for the field] */
    public $breadcrumbs;

    /** @var object */
    public $resolveCallback;

    /** @var string [Set the field label tag] */
    public $label;

    /** @var string [The field relationship. Mostly for text fields wich want to show a relationship] */
    public $fieldRelationship;

    /** @var string [The model relationships] */
    public $relationships;

    /** @var array [List of attributes to be dynamically render] */
    public $renderAttributes = ['id', 'dusk'];

    /** @var string [All the render attributes must be stored here...] */
    public $render;

    /** @var bool [Indicates if the field should be sortable] */
    public $sortable = false;

    /** @var string [Table text align. Only on controller action: index] */
    public $textAlign = 'left';

    /** @var mixed [The field value (Resolved and updated...)] */
    public $value;

    /**
     * Set the field sortable
     *
     *@param  bool  $value
     * @return self
     */
    public function sortable(bool $value = true) : self
    {
        if(!empty($value)) {
            $this->sortable = true;
        }

        return $this;
    }

    /**
     * Set the field sortable
     *@param  bool  $value
     * @return self
     */
    public function textAlign(string $value = 'left') : self
    {
        if(!empty($value)) {
            $this->textAlign = $value;
        }

        return $this;
    }

    /**
     * Resolving field value
     *@param  object  $resolveCallback
     * @return self
     */
    public function resolveUsing(callable $resolveCallback) : self
    {
        if(!empty($resolveCallback)) {
            $this->resolveCallback = $resolveCallback;
        }

        return $this;
    }
}
