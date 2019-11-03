<?php

namespace Daguilarm\Belich\Core;

use Daguilarm\Belich\Fields\FieldResolveIndex;

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

    /**
     * Initialize the html helper in order to be accesible from Belich
     *
     * @return \Daguilarm\Fields\FieldResolveIndex
     */
    public function html(): FieldResolveIndex
    {
        return app(FieldResolveIndex::class);
    }

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
