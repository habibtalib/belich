<?php

namespace Daguilarm\Belich\Fields\Traits\Constructable;

use Daguilarm\Belich\Core\Belich;
use Daguilarm\Belich\Fields\Field;

trait Softdeleteable {

    /**
    * Resolve if the row is softdeleted
    * This method is used throw Belich Facade => Belich::html()->resolveSoftdeleting($field, $data);
    * This method is for refactoring the blade templates.
    *
    * @param  Daguilarm\Belich\Fields\Field $attribute
    * @param  object $data
    * @return null|string
    */
    public function resolveSoftdeleting(Field $field, object $data = null)
    {
        return method_exists(Belich::getModel(), 'trashed') && $data->trashed();
    }
}
