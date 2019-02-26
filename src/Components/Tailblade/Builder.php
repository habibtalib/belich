<?php

namespace Daguilarm\Belich\Components\Tailblade;

use Daguilarm\Belich\Components\Tailblade\Tailwind;

abstract class Builder {

    use Tailwind;

    /** @var array */
    private $config;

    /** @var string */
    private $container;

    /** @var array */
    private $css;

    /** @var array */
    private $attributes;

    /**
     * Initialize the constructor
     */
    public function __construct()
    {
        $this->config = include(__DIR__ . '/Config.php');
    }
}
