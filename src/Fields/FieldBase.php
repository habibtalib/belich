<?php

namespace Daguilarm\Belich\Fields;

class FieldBase
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
     * Show as html
     *
     * @var bool
     */
    public $asHtml;

    /**
     * The attribute / column name of the field
     *
     * @var string
     */
    public $attribute;

    /**
     * The custom breadcrumbs for the field
     *
     * @var string
     */
    public $breadcrumbs;

    /**
     * The data from the model
     *
     * @var object
     */
    public $data;

    /**
     * For manipulate data
     *
     * @var \Closure|null
     */
    public $displayCallback;

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
     * Disable $this->displayUsing()
     *
     * @var bool
     */
    public $notDisplayUsing;

    /**
     * Disable $this->resolveUsing()
     *
     * @var bool
     */
    public $notResolveUsing;

    /**
     * Group by panel
     *
     * @var string
     */
    public $panel;

    /**
     * Prefix for field value
     *
     * @var string
     */
    public $prefix;

    /**
     * The model relationships
     *
     * @var string
     */
    public $relationships;

    /**
     * List of attributes to be dynamically render
     *
     * @var array
     */
    public $renderAttributes = ['id', 'name', 'dusk'];

    /**
     * All the render attributes must be stored here...
     *
     * @var array
     */
    public $render = [];

    /**
     * All the attributes to be removed from $field
     *
     * @var array
     */
    public $removedAttr = [];

    /**
     * For manipulate data
     *
     * @var \Closure|null
     */
    public $resolveCallback;

    /**
     * @var \Closure|null
     */
    public $seeCallback;

    /**
     * Indicates if the field should be sortable
     *
     * @var bool
     */
    public $sortable = false;

    /**
     * Suffix for field value
     *
     * @var string
     */
    public $suffix;

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
     * Resolve the value as HTML (without scape)
     *
     * @return self
     */
    public function asHtml(): self
    {
        $this->asHtml = true;
        $this->visibleOn('index', 'show');

        return $this;
    }

    /**
     * Set the callback to be run to authorize viewing the field.
     *
     * @param  \Closure  $callback
     *
     * @return self
     */
    public function canSee(\Closure $callback): self
    {
        $this->seeCallback = $callback;

        return $this;
    }

    /**
     * Set the field sortable
     *
     * @return self
     */
    public function sortable(): self
    {
        $this->sortable = true;

        return $this;
    }

    /**
     * Resolving field value in index and detailed
     *
     * @param  object  $displayCallback
     *
     * @return self
     */
    public function displayUsing(callable $displayCallback): self
    {
        $this->displayCallback[] = $displayCallback ?? [];

        return $this;
    }

    /**
     * Resolving field value (before processing) in all the fields
     *
     * @param  object  $resolveCallback
     *
     * @return self
     */
    public function resolveUsing(callable $resolveCallback): self
    {
        $this->resolveCallback = $resolveCallback;

        return $this;
    }

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

    /**
     * Prefix for field value
     *
     * @param  string  $prefix
     * @param  bool  $space
     *
     * @return self
     */
    public function prefix(string $prefix, bool $space = false): self
    {
        $this->displayUsing(static function ($value) use ($prefix, $space) {
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
     *
     * @param  string  $suffix
     * @param  bool  $space
     *
     * @return self
     */
    public function suffix(string $suffix, bool $space = false): self
    {
        $this->displayUsing(static function ($value) use ($suffix, $space) {
            return sprintf(
                '%s%s%s',
                $value,
                $space ? ' ' : '',
                $suffix
            );
        });

        return $this;
    }

    /**
     * Not Resolving field value
     * This is (mostly) for hidden fields
     *
     * @return self
     */
    public function notResolveField(): self
    {
        //Not display using
        $this->notDisplayUsing = false;

        //Not resolve using
        $this->notResolveUsing = false;

        return $this;
    }

    /**
     * Remove attributes from $field
     * Just for internal use
     *
     * @param array $attributes
     *
     * @return self
     */
    protected function removedAttr(array ...$attributes): self
    {
        $this->removedAttr = $attributes;

        return $this;
    }
}
