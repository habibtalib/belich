<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Components\Cards;

use Daguilarm\Belich\Contracts\ComponentContract;

abstract class Card implements ComponentContract
{
    public string $uriKey;
    public string $view;
    public string $width = 'w-full';
    public array $withMeta;

    public function __construct()
    {
        $this->uriKey = $this->uriKey();
        $this->view = $this->view();
        $this->withMeta = $this->withMeta();
    }

    /**
     * Render the card view
     */
    abstract public function view(): string;

    /**
     * Get the URI key for the card
     */
    abstract public function uriKey(): string;

    /**
     * Get the URI key for the card
     */
    abstract public function withMeta(): array;

    /**
     * Get the width for the card
     */
    public function width(string $width): self
    {
        $this->width = $width;

        return $this;
    }
}
