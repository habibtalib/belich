<?php

namespace Daguilarm\Belich\Components\Cards;

use Daguilarm\Belich\Contracts\ComponentContract;

abstract class Card implements ComponentContract
{
    /**
     * @var string
     */
    public $uriKey;

    /**
     * @var string
     */
    public $view;

    /**
     * @var string
     */
    public $width = 'w-full';

    /**
     * @var array
     */
    public $withMeta;

    /**
     * Initialize the metric
     */
    public function __construct()
    {
        $this->uriKey = $this->uriKey();
        $this->view = $this->view();
        $this->withMeta = $this->withMeta();
    }

    /**
     * Render the card view
     *
     * @return string
     */
    abstract public function view(): string;

    /**
     * Get the URI key for the card
     *
     * @return string
     */
    abstract public function uriKey(): string;

    /**
     * Get the URI key for the card
     *
     * @return array
     */
    abstract public function withMeta(): array;

    /**
     * Get the width for the card
     *
     * @param string $width
     *
     * @return self
     */
    public function width(string $width): self
    {
        $this->width = $width;

        return $this;
    }
}
