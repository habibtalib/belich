<?php

namespace Daguilarm\Belich\Components\Navigation\Traits;

trait Settings {

    private $settingCallback;

    /*
    |--------------------------------------------------------------------------
    | Brand
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


}
