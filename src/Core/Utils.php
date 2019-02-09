<?php

namespace Daguilarm\Belich\Core;

use Daguilarm\Belich\Core\BelichHelpers as Helpers;
use Daguilarm\Belich\Fields\Field;

class Utils {

    /**
     * Generate the methods
     *
     * @param  string $method
     * @param  array $parameters
     *
     * @return Boolean
     */
    public function __call($method, $parameters)
    {
        if(method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $parameters);
        }

        return abort(404);
    }

    /**
     * Generate the url with all the parameters
     *
     * @param  array $urlParameters
     *
     * @return string
     */
    private function url($urlParameters = null) : string
    {
        $parameters = $urlParameters ?? $this->urlParameters();

        return sprintf('%s/?%s', url()->current(), $this->serializeParameters($parameters));
    }

    /**
     * Generate the link with all the parameters for the table header
     *
     * @param  Daguilarm\Belich\Fields\Field $field
     *
     * @return string
     */
    private function urlWithOrder(Field $field) : string
    {
        //Filter if attribute is a relationship or is not sortable
        if(is_array($field->attribute) || $field->sortable === false) {
            return $field->label;
        }

        $parameters = array_merge($this->urlParameters(), [
            'order'     => $field->attribute,
            'direction' => $this->urlParameters('direction') === 'DESC' ? 'ASC' : 'DESC',
        ]);

        return sprintf('<a href="%s">%s</a>', $this->url($parameters), $field->label);
    }

    /**
     * Count the total results
     *
     * @param  array|object $value
     * @param  int $initialValue
     *
     * @return integer
     */
    private function count($value, int $initialValue = 0) : int
    {
        if(is_array($value)) {
            return count($value) + $initialValue;
        }

        if(is_object($value)) {
            return $value->count() + $initialValue;
        }

        return 0;
    }

    /**
     * Get all the url parameters in an array or a selected one
     *
     * @param string $key
     * @return array|string
     */
    private function urlParameters($key = null)
    {
        return $key
            ? request()->query($key)
            : request()->query();
    }

    /**
     * Serialize all the url parameters
     *
     * @param array $parameters
     * @return string
     */
    private function serializeParameters($parameters = null)
    {
        return collect($parameters ?? $this->urlParameters())
            ->map(function($value, $key) {
                return sprintf('%s=%s', $key, $value);
            })
            ->values()
            ->implode('&');
    }

    /**
     * Get the base path for the package
     *
     * @return string
     */
    private function basePath() : string
    {
        return str_replace('/', '', config('belich.path'));
    }

    /**
     * Generate the form route for the action attribute
     *
     * @param string $redirectTo ['index', 'edit', 'update', 'show']
     * @return string
     */
    private function formRedirectTo(string $redirectTo) : string
    {
        $route = sprintf('%s.%s.%s', $this->basePath(), Helpers::resource(), $redirectTo);
        $id    = Helpers::resourceId() ?? 0;

        return ($id > 0)
            ? route($route, $id)
            : route($route);
    }

    /**
     * Get the name from a file string [file.ext]
     *
     * @param string $fileName
     * @param bool $extension
     * @return string
     */
    private function getFileAttributes(string $fileName, $extension = false) : string
    {
        $str = explode('.', $fileName);

        return (!empty($str) && count($str) === 2)
            ? ($extension ? $str[1] : $str[0])
            : emptyResults();
    }

    /**
     * Render the icons
     *
     * @param string $icon
     * @param string $text
     * @return string
     */
    private function icon(string $icon, string $text = '') : string
    {
        $icon = sprintf('<i class="fas fa-%s mr-1"></i>', $icon);

        return $text
            ? $icon . ' ' . $text
            : $icon;
    }

    /**
     * Render the icons
     *
     * @param string $controllerAction
     * @param object $data
     * @return string
     */
    private function route(string $controllerAction, $data) : string
    {
        $route = sprintf('%s.%s.%s', Utils::basePath(), Belich::resource(), $controllerAction);

        return route($route, $data->id);
    }
}
