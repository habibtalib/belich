<?php

namespace Daguilarm\Belich\Fields;

use Daguilarm\Belich\Core\Traits\Routeable;
use Daguilarm\Belich\Fields\Field;
use Daguilarm\Belich\Fields\Traits\Constructable\Authorizable;
use Daguilarm\Belich\Fields\Traits\Constructable\Renderable;
use Daguilarm\Belich\Fields\Traits\Constructable\Valuable;
use Daguilarm\Belich\Fields\Traits\Resolvable;
use Illuminate\Support\Collection;

final class FieldResolve
{
    use Authorizable,
        Renderable,
        Resolvable,
        Routeable,
        Valuable;

    /**
     * @var string
     */
    private $action;

    /**
     * Get controller action
     *
     * @return string
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
        $this->setAuthorizationFromPolicy($sqlResponse);

        //Authorization & Visibility
        $fields = $this->filterFields($fields);

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
            : $this->setCrudController($fields, $sqlResponse);
    }

    /**
     * Resolve fields: authorization and visibility
     *
     * @param object $fields
     *
     * @return object
     */
    private function filterFields(object $fields): object
    {
        //Authorized: $field->canSee()
        $fields = $this->setAuthorizationForFields($fields);

        //Visibility: Show or hide fields base on Resource settings
        return $this->setVisibilityForFields($fields);
    }
}
