<?php

namespace Daguilarm\Belich\Components\Cards;

abstract class Card
{
    /** @var string */
    public $view;

    /** @var array */
    public $withMeta;

    /** @var string */
    public $uriKey;

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
     * Initialize the card
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
}
