<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Traits;

trait Renderable
{
    /**
     * @var array|string
     */
    public $render;

    public bool $asHtml = false;
    public array $renderAttributes = ['id', 'name', 'dusk'];

    /**
     * Resolve the value as HTML (without scape)
     */
    public function asHtml(): self
    {
        $this->asHtml = true;
        $this->visibleOn('index', 'show');

        return $this;
    }
}
