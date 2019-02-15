<?php

namespace Daguilarm\Belich\Components\Navigation\Traits;

trait Settings {

    private $settingCallback;

    /*
    |--------------------------------------------------------------------------
    | Settings
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

    /*
    |--------------------------------------------------------------------------
    | Css
    |--------------------------------------------------------------------------
    */

   /**
    * Set the menu CSS
    *
    * @return $this
    */
    public function menuCss()
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
    public function submenuCss()
    {
        return $this->merge(
            $this->submenuBackground,
            $this->submenuBackgroundHover,
        );
    }
}
