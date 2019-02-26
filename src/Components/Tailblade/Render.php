<?php

namespace Daguilarm\Belich\Components\Tailblade;

use Daguilarm\Belich\Components\Tailblade\Builder;
use Illuminate\Support\Str;

class Render extends Builder {

    /**
     * Initialize the constructor
     */
    public function __construct()
    {
        parent::__construct();
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

        $this->css[] = $items
            ? sprintf('%s-%s', Str::kebab($method), $items)
            : Str::kebab($method);

        return $this;
    }

    /**
     * Create a new container
     *
     * @return string
     */
    public function create()
    {
        return dd($this);
    }

    /**
     * Close the container
     *
     * @return string
     */
    public function close()
    {
        return $this;
    }
}
