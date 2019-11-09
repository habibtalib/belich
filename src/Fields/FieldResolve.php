<?php

namespace Daguilarm\Belich\Fields;

use Daguilarm\Belich\Core\Traits\Routeable;
use Daguilarm\Belich\Fields\FieldResolveBase;
use Daguilarm\Belich\Fields\Traits\Constructable\Renderable;
use Daguilarm\Belich\Fields\Traits\Constructable\Valuable;
use Illuminate\Support\Collection;

final class FieldResolve extends FieldResolveBase
{
    use Renderable,
        Routeable,
        Valuable;

    /**
     * @var string
     */
    private $action;

    /**
     * Get controller action
     */
    public function __construct()
    {
        $this->action = Routeable::action();
    }

    /**
     * Resolve fields: auth, visibility, value,...
     *
     * @param object $class
     * @param object $fields
     * @param object $sqlResponse
     *
     * @return Illuminate\Support\Collection
     */
    public function make(object $class, object $fields, object $sqlResponse): Collection
    {
        //Filter
        //Prepare the fields for resolving...
        $fields = $fields->flatten();

        //Policies
        //Authorization for 'show', 'edit' and 'update' actions
        //This go here because we want to avoid duplicated sql queries...Don't remove!!!
        $this->setAuthorizationFromPolicy($sqlResponse, $this->action);

        //Authorization for fields
        $fields = $this->setAuthorizationForFields($fields);

        //Visibility for fields
        $fields = $this->setVisibilityForFields($fields, $this->action);

        //Controller actions
        //Resolve fields base on the controller action
        //No resolve field for not visual actions
        if ($this->action === 'store' || $this->action === 'update' || $this->action === 'destroy') {
            return new Collection();
        }

        // Check for action value
        return $this->action === 'index'
            //Prepare the field for the index response
            ? app(\Daguilarm\Belich\Fields\FieldResolveIndex::class)->make($fields, $sqlResponse)
            //Prepare the field for the the form response: create, edit and show
            : $this->setCrudController($fields, $sqlResponse, $this->action);
    }
}
