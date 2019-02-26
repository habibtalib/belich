<?php

namespace Daguilarm\Belich\Components\Tailblade;

use Daguilarm\Belich\Components\Tailblade\Builder;
use Illuminate\Support\Arr;

class Render extends Builder {

    /**
     * Initialize the constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Create a new container
     *
     * @return string
     */
    public function create()
    {
        return sprintf(
            '<%s %s %s>',
            $this->container,
            $this->renderAttributes(),
            $this->renderClasses()
        );
    }

    /**
     * Close the container
     *
     * @return string
     */
    public function close()
    {
        return sprintf('</%s>', $this->container);
    }

    /*
    |--------------------------------------------------------------------------
    | Render helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Render attributes
     *
     * @return string
     */
    private function renderAttributes() : string
    {
        return collect($this->attributes)
            ->map(function($value, $key) {
                return sprintf('%s="%s"', $key, $value);
            })
            ->sort()
            ->implode(' ');
    }

    /**
     * Render classes
     *
     * @return string
     */
    private function renderClasses() : string
    {
        $classes = collect($this->classes)
            ->map(function($value) {
                return $value;
            })
            ->filter()
            ->sort()
            ->implode(' ');

        return $classes
            ? sprintf('class="%s"', $classes)
            : '';
    }
}
