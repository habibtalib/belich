<?php

namespace Daguilarm\Belich\Components\Tailblade;

use Daguilarm\Belich\Components\Tailblade\Traits\Css;
use Daguilarm\Belich\Components\Tailblade\Traits\Dimensions;
use Daguilarm\Belich\Components\Tailblade\Traits\Responsive;
use Daguilarm\Belich\Components\Tailblade\Traits\States;
use Daguilarm\Belich\Components\Tailblade\Traits\Tailwind;
use Daguilarm\Belich\Components\Tailblade\Traits\Utilities;
use Illuminate\Support\Str;

abstract class Builder {

    use Css, Dimensions, Responsive, States, Tailwind, Utilities;

    /** @var array */
    protected $config;

    /** @var string */
    protected $container;

    /** @var array */
    protected $classes;

    /** @var array */
    protected $attributes;

    /**
     * Initialize the constructor
     */
    public function __construct()
    {
        $this->config = include(__DIR__ . '/Config.php');
    }

    /**
     * Initialize the container
     *
     * @param string $container
     * @return self
     */
    public function make(string $container = 'div') : self
    {
        $this->container = $container;

        return $this;
    }

    /**
     * Create a new attribute
     *
     * @param string $attribute
     * @param int|string $value
     * @return self
     */
    public function attributes(string $attribute, $value) : self
    {
        $this->attributes[$attribute] = $value;

        return $this;
    }

    /**
     * Create a new tailwind classes with magic!
     *
     * @param string $method
     * @param array $args
     * @return self
     */
    public function __call(string $method, array $args)
    {
        $items = collect($args)
            ->map(function($value) {
                return $value;
            })
            ->filter()
            ->implode('-');

        $this->classes[] = $items
            ? sprintf('%s-%s', Str::kebab($method), $items)
            : Str::kebab($method);

        return $this;
    }
}
