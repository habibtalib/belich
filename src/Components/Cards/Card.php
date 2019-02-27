<?php

namespace Daguilarm\Belich\Components\Cards;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;

abstract class Card {

    /** @var string */
    public $width;

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
    }

    /**
     * Return the view
     *
     * @return Illuminate\Support\Facades\View
     */
    abstract public function render() : View;

    /**
     * Get the URI key for the card
     *
     * @return string
     */
    abstract public function uriKey() : string;

    /**
     * Set the default card width
     *
     * @param string $width
     * @return self
     */
    public function width(string $width) : self
    {
        $this->width = $width;

        return $this;
    }
}
