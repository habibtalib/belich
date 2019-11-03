<?php

namespace Daguilarm\Belich\Components\Cards;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

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
     *
     * @return string
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
    abstract public function view() : string;

    /**
     * Get the URI key for the card
     *
     * @return string
     */
    abstract public function uriKey() : string;

    /**
     * Get the URI key for the card
     *
     * @return string
     */
    abstract public function withMeta() : array;
}
