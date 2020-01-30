<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Validates;

use Daguilarm\Belich\Facades\Belich;
use Illuminate\Support\Facades\File;
use MatthiasMullie\Minify;

final class Javascript
{
    private array $stubReplace = [
        ':resource',
        ':action',
        ':values',
        ':validationRules',
        ':validationAttributes',
        ':validationRuoute',
    ];

    /**
     * Render the javascript code
     */
    public function render(object $attributes, string $controllerAction, string $resource, object $rules, string $values): string
    {
        //Get the javascript stub
        $stub = File::get(config_path('belich/stubs/validate-form.stub'));

        //Set the route for validation
        $route = route(Belich::pathName() .'.ajax.form.validation');

        //Stub values
        $stubValues = [
            $resource,
            $controllerAction,
            $values,
            $rules,
            $attributes,
            $route,
        ];

        //Get the javascript code
        $script = str_replace($this->stubReplace, $stubValues, $stub);

        //Minify the javascript code
        return $this->minify($script);
    }

    /**
     * Minify the javascript
     */
    private function minify(string $script): string
    {
        return (new Minify\Js($script))->minify();
    }
}
