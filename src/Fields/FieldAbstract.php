<?php

namespace Daguilarm\Belich\Fields;

abstract class FieldAbstract {

    /** @var array [List of allowed controller actions] */
    public $allowedControllerActions = [
        'index',
        'create',
        'edit',
        'show'
    ];

    /** @var bool [Show as html] */
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

    /** @var string [Group by panel] */
    public $panel;

    /** @var string [Prefix for field value] */
    public $prefix;

    /** @var string [The model relationships] */
    public $relationships;

    /** @var array [List of attributes to be dynamically render] */
    public $renderAttributes = ['id', 'name', 'dusk'];

    /** @var string [All the render attributes must be stored here...] */
    public $render;

    /** @var array [All the attributes to be removed from $field] */
    public $removedAttr = [];

    /** @var \Closure|null for manipulate data */
    public $resolveCallback;

    /** @var \Closure|null */
    public $seeCallback;

    /** @var bool [Indicates if the field should be sortable] */
    public $sortable = false;

    /** @var string [Suffix for field value] */
    public $suffix;

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
        $this->visibleOn('index', 'show');

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
            $this->displayCallback[] = $displayCallback;
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
     * Group field into panels
     * @param  string  $panel
     * @return self
     */
    public function panels(string $panel)
    {
        $this->panels = $panel;

        return $this;
    }

    /**
     * Prefix for field value
     * @param  string  $prefix
     * @param  bool  $space
     * @return self
     */
    public function prefix(string $prefix, bool $space = false)
    {
        $this->displayUsing(function($value) use ($prefix, $space) {
            return sprintf(
                '%s%s%s',
                $prefix, $space ? ' ' : '',
                $value
            );
        });

        return $this;
    }

    /**
     * Suffix for field value
     * @param  string  $suffix
     * @param  bool  $space
     * @return self
     */
    public function suffix(string $suffix, bool $space = false)
    {
        $this->displayUsing(function($value) use ($suffix, $space) {
            return sprintf(
                '%s%s%s',
                $value,
                $space ? ' ' : '',
                $suffix

            );
            return $suffix ? $value . $suffix  : $value;
        });

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

    /**
     * Remove attributes from $field
     * @param  array  $attributes
     * @return self
     */
    public function removedAttr(...$attributes) : self
    {
        $this->removedAttr = $attributes;

        return $this;
    }
}
