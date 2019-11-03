<?php

namespace Daguilarm\Belich\Core;

class BelichAbstract
{
    /** @var array */
    public static $allowedActions = [
        'index',
        'create',
        'edit',
        'show'
    ];

    /**
     * Get the allowed actions
     *
     * @return array
     */
    public static function allowedActions(): array
    {
        return static::$allowedActions;
    }

    /*
    |--------------------------------------------------------------------------
    | Init resource class
    |--------------------------------------------------------------------------
    */
    /**
     * Init the current class
     *
     * @return object
     */
    protected function initResourceClass(): object
    {
        //Set the initial class
        $class = static::resourceClassPath();

        return new $class;
    }
}
