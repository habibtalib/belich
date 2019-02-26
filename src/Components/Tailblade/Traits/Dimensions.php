<?php

namespace Daguilarm\Belich\Components\Tailblade\Traits;

trait Dimensions {

    /*
    |--------------------------------------------------------------------------
    | Dimensions
    |--------------------------------------------------------------------------
    */

    /**
     * Width value
     *
     * @param array $size
     * @return self
     */
    public function width(string $size) : self
    {
        $value = explode('-', $size);

        $this->classes[] = 'w-' . $this->getValidateConfig('width', $value[1], $default = 'full');

        return $this;
    }

    /**
     * Hight value
     *
     * @param array $size
     * @return self
     */
    public function height(string $size) : self
    {
        $value = explode('-', $size);

        $this->classes[] = 'h-' . $this->getValidateConfig('height', $value[1], 'full');

        return $this;
    }
}
