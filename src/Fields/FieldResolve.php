<?php

namespace Daguilarm\Belich\Fields;

use Daguilarm\Belich\Fields\Field;
use Daguilarm\Belich\Core\Traits\Route as Helpers;
use Daguilarm\Belich\Fields\Traits\Resolve;
use Illuminate\Support\Collection;

class FieldResolve {

    use Helpers, Resolve;

    /** @var string */
    private $action;

    /**
     * Get controller action
     *
     * @return string
     */
    public function __construct()
    {
        $this->action = Helpers::action();
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
        //Policy authorization for 'show', 'edit' and 'update' actions
        //This go here because we want to avoid duplicated sql queries...Don't remove!!!
        $this->setAuthorizationFromPolicy($sqlResponse);

        //Authorized fields: $field->canSee()
        $fields = $this->setAuthorizationForFields($fields);

        //Show or hide fields base on Resource settings
        $fields = $this->setVisibilityForFields($fields);

        //Resolve fields base on the controller action
        return $this->setControllerActionForFields($fields, $sqlResponse);
    }
}
