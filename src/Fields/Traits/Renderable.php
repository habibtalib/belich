<?php

namespace Daguilarm\Belich\Fields\Traits;

trait Renderable
{
    /**
     * Show as html
     *
     * @var bool
     */
    public $asHtml;

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
}
