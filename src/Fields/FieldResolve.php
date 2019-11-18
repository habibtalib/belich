<?php

namespace Daguilarm\Belich\Fields;

use Daguilarm\Belich\Core\Traits\Routeable;
use Daguilarm\Belich\Fields\Abstracts\FieldResolve as FieldResolveAbstract;
use Daguilarm\Belich\Fields\Traits\Constructable\Renderable;
use Daguilarm\Belich\Fields\Traits\Constructable\Valuable;
use Illuminate\Support\Collection;

final class FieldResolve extends FieldResolveAbstract
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
     * @param object $fields
     * @param object $sql
     *
     * @return Illuminate\Support\Collection
     */
    public function make(object $fields, object $sql): Collection
    {
        //Filter
        //Prepare the fields for resolving...
        $fields = $fields->flatten();

        //Policies
        //Authorization for 'show', 'edit' and 'update' actions
        //This go here because we want to avoid duplicated sql queries...Don't remove!!!
        $this->authorizationFromPolicy($sql, $this->action);

        //Authorization for fields
        $fields = $this->authorizationForFields($fields);

        //Visibility for fields
        $fields = $this->visibilityForFields($fields, $this->action);

        //Controller actions
        //Resolve fields base on the controller action
        //No resolve field for not visual actions
        if ($this->action === 'store' || $this->action === 'update' || $this->action === 'destroy') {
            return new Collection();
        }
        // Check for action value
        return $this->action === 'index'
            //Prepare the field for the index response
            ? app(\Daguilarm\Belich\Fields\FieldResolveIndex::class)->make($fields)
            //Prepare the field for the the form response: create, edit and show
            : $this->crudController($fields, $sql, $this->action);
    }
}
