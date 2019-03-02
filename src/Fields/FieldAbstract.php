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

    /** @var bool */
    public $asHtml;

    /** @var string [The attribute / column name of the field] */
    public $attribute;

    /** @var string [The custom breadcrumbs for the field] */
    public $breadcrumbs;

    /** @var object model data */
    public $data;

    /** @var \Closure|null for manipulate data */
    public $displayCallback;

    /** @var string [The field relationship. Mostly for text fields wich want to show a relationship] */
    public $fieldRelationship;

    /** @var string [Set the field label tag] */
    public $label;

    /** @var bool */
    public $notResolveField;

    /** @var string [The model relationships] */
    public $relationships;

    /** @var array [List of attributes to be dynamically render] */
    public $renderAttributes = ['id', 'name', 'dusk'];

    /** @var string [All the render attributes must be stored here...] */
    public $render;

    /** @var \Closure|null for manipulate data */
    public $resolveCallback;

    /** @var \Closure|null */
    public $seeCallback;

    /** @var bool [Indicates if the field should be sortable] */
    public $sortable = false;

    /** @var string [Table text align. Only on controller action: index] */
    public $textAlign = 'left';

    /** @var mixed [The field value (Resolved and updated...)] */
    public $value;

    /**
     * Resolve the value as HTML (without scape)
     *
     * @return self
     */
    public function asHtml() : self
    {
        $this->asHtml = true;

        return $this;
    }

    /**
     * Set the callback to be run to authorize viewing the field.
     *
     * @param  \Closure  $callback
     * @return self
     */
    public function canSee(\Closure $callback) : self
    {
        $this->seeCallback = $callback;

        return $this;
    }

    /**
     * Set the field sortable
     *
     * @param  bool  $value
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
     * Set the field align
     * @param  bool  $value
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
     * Resolving field value in index and detailed
     * @param  object  $displayCallback
     * @return self
     */
    public function displayUsing(callable $displayCallback) : self
    {
        if(!empty($displayCallback)) {
            $this->displayCallback = $displayCallback;
        }

        return $this;
    }

    /**
     * Resolving field value (before processing) in all the fields
     * @param  object  $resolveCallback
     * @return self
     */
    public function resolveUsing(callable $resolveCallback) : self
    {
        if(!empty($resolveCallback)) {
            $this->resolveCallback = $resolveCallback;
        }

        return $this;
    }

    /**
     * Not Resolving field value
     * This is (mostly) for hidden fields
     * @return self
     */
    public function notResolveField() : self
    {
        $this->notResolveField = true;

        return $this;
    }
}
