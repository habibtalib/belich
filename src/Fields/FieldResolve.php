<?php

namespace Daguilarm\Belich\Fields;

use Daguilarm\Belich\Core\Traits\Routeable;
use Daguilarm\Belich\Fields\Field;
use Daguilarm\Belich\Fields\Traits\Resolvable;
use Illuminate\Support\Collection;

class FieldResolve {

    use Resolvable, Routeable;

    /** @var string */
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
     * @return Illuminate\Support\Collection
     */
    public function make(object $class, object $fields, object $sqlResponse) : Collection
    {
        //Filter
        //Prepare the fields for resolving...
        $fields = $this->prepareFields($fields);

        //Policies
        //Authorization for 'show', 'edit' and 'update' actions
        //This go here because we want to avoid duplicated sql queries...Don't remove!!!
        $this->setAuthorizationFromPolicy($sqlResponse);

        //Authorized: $field->canSee()
        $fields = $this->setAuthorizationForFields($fields);

        //Visibility: Show or hide fields base on Resource settings
        $fields = $this->setVisibilityForFields($fields);

        //Controller actions
        //Resolve fields base on the controller action
        return $this->setControllerActionForFields($fields, $sqlResponse);
    }

    /**
     * Prepare the fields to be resolve
     *
     * @param object $fields
     * @return Illuminate\Support\Collection
     */
    private function prepareFields($fields) : Collection
    {
        //Prepare for tabs
        $fields = $fields->flatten();

        return $fields;
    }
}
