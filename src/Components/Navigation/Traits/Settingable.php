<?php

namespace Daguilarm\Belich\Components\Navigation\Traits;

trait Settingable {

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
        if(empty($getCallback = call_user_func($callback))) {
            return $this;
        }

        foreach($getCallback as $key => $value) {
            if($value && $key) {
                $this->{$key} = $value;
            }
        }

        return $this;
    }

    /**
     * Set the dropdown icon
     *
     * @param  string  $icon
     * @return $this
     */
    public function setDropdownIcon(string $icon)
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
        return $this->dropdownIcon ?? icon('caret-down', $text = '', $css = 'ml-1 icon');
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

    /**
     * Set the links CSS
     *
     * @return $this
     */
    private function linkCss()
    {
        return $this->merge(
            $this->linkColor,
            $this->linkColorHover,
        );
    }

    /**
     * Set the brand CSS
     *
     * @return $this
     */
    private function brandCss()
    {
        return $this->merge(
            $this->brandText,
            $this->brandWidth,
            $this->brandBackground
        );
    }

    /**
     * Set the brand link CSS
     *
     * @return $this
     */
    private function brandLinkCss()
    {
        return $this->merge(
            $this->brandLink,
            $this->brandLinkHover,
        );
    }
}
