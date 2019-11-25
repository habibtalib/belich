<?php

namespace Daguilarm\Belich\Fields\Validates;

use Daguilarm\Belich\Facades\Belich;
use Illuminate\Support\Facades\File;
use MatthiasMullie\Minify;

final class Javascript
{
    /**
     * Stub replace values
     *
     * @var array
     */
    private $stubReplace = [
        ':resource',
        ':action',
        ':values',
        ':validationRules',
        ':validationAttributes',
        ':validationRuoute',
    ];

    /**
     * Render the javascript code
     *
     * @param string $values
     * @param string $rules
     * @param string $values
     *
     * @return string
     */
    public function render(string $attributes, string $controllerAction, $resource, string $rules, string $values): string
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
     *
     * @param string $script
     *
     * @return string
     */
    private function minify(string $script): string
    {
        return (new Minify\Js($script))->minify();
    }
}
