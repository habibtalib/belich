<?php

namespace Daguilarm\Belich\Components\Tailblade;

trait Tailwind {

    /*
    |--------------------------------------------------------------------------
    | Tailwindcss methods
    |--------------------------------------------------------------------------
    */

    /**
     * Generate the margin
     *
     * @param string $direction
     * @param int $value
     * @return self
     */
    public function margin($direction, int $value = 0) : self
    {
        $this->css[] = $this->getSpacing($direction, $value, $type = 'm');

        return $this;
    }

    /**
     * Generate the padding
     *
     * @param string $direction
     * @param int $value
     * @return self
     */
    public function padding($direction, int $value = 0) : self
    {
        $this->css[] = $this->getSpacing($direction, $value, $type = 'p');

        return $this;
    }

    /**
     * Generate the text color
     *
     * @param array $arg
     * @return self
     */
    public function color(...$arg) : self
    {
        $this->css[] = $this->getColor('text', ...$arg);

        return $this;
    }

    /**
     * Generate the background color
     *
     * @param array $arg
     * @return self
     */
    public function background(...$arg) : self
    {
        $this->css[] = $this->getColor('bg', ...$arg);

        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Tailwindcss helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Generate the spacing values: margin and padding
     *
     * @param string $direction
     * @param int $value
     * @param string $type
     * @return string
     */
    private function getSpacing(string $direction, int $value = 0, string $type) : string
    {
        //Set direction
        $direction = in_array($direction, $this->config['spacing']['directions'])
            ? substr($direction, 0, 1)
            : '';

        //Set value
        $spacing =  ($value <= 0 && is_int($direction))
            ? $direction
            : $value;

        //Without direction
        if($value <= 0 && is_int($direction)) {
            return sprintf('%s-%s', $type, $spacing);
        }

        //With direction
        return sprintf('%s%s-%s', $type, $direction, $spacing);
    }

    /**
     * Generate the color values: text-color and bg-color
     *
     * @param string $type
     * @param array $arg
     * @return string
     */
    private function getColor(string $type, ...$arg) : string
    {
        return collect($arg)
            ->map(function($value) {
                return $value;
            })
            ->prepend($type)
            ->filter()
            ->implode('-');
    }
}
