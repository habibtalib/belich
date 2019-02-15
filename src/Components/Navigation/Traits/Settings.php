<?php

namespace Daguilarm\Belich\Components\Navigation\Traits;

trait Settings {

    private $settingCallback;

    /*
    |--------------------------------------------------------------------------
    | Public methods
    |--------------------------------------------------------------------------
    */

    /**
     * Set the callback for the settings
     *
     * @param  \Closure  $callback
     * @return $this
     */
    public function settings(\Closure $callback)
    {
        foreach(call_user_func($callback) as $key => $value) {
            if($value) {
                $this->{$key} = $value;
            }
        }

        return $this;
    }

    /**
     * Set the callback for the settings
     *
     * @param  \Closure  $callback
     * @return $this
     */
    public function setDropdownIcon($icon)
    {
        $this->dropdownIcon = $icon;

        return $this;
    }

    /**
     * Set the callback for the settings
     *
     * @param  \Closure  $callback
     * @return $this
     */
    public function getDropdownIcon()
    {
        return $this->dropdownIcon ?? icon('caret-down', $text = '', $css = 'ml-1');
    }

    /*
    |--------------------------------------------------------------------------
    | Private methods
    |--------------------------------------------------------------------------
    */

   /**
    * Set the menu CSS
    *
    * @return $this
    */
    private function menuCss()
    {
        return $this->merge(
            $this->menuBackground,
            $this->menuBackgroundHover,
        );
    }

    /**
     * Set the submenu CSS
     *
     * @return $this
     */
    private function submenuCss()
    {
        return $this->merge(
            $this->submenuBackground,
            $this->submenuBackgroundHover,
        );
    }
}
