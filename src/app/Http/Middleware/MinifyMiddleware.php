<?php

namespace Daguilarm\Belich\App\Http\Middleware;

use Closure;

/**
 * @author: https://github.com/nckg/laravel-minify-html
 * It's not server as a package for simplyfy integration with the config.php
 */
class MinifyMiddleware
{
    private $htmlFilters = [
        // Remove HTML comments except IE conditions
        '/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s' => '',
        // Remove comments in the form /* */
        '/(?<!\S)\/\/\s*[^\r\n]*/' => '',
        // Shorten multiple white spaces
        '/\s{2,}/' => ' ',
        // Remove whitespaces between HTML tags
        '/>\s{2,}</' => '><',
        // Collapse new lines
        '/(\r?\n)/' => '',
    ];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var Response $response */
        $response = $next($request);

        if (config('belich.minifyHtml') && $this->isHtml($response)) {
            $response->setContent($this->html($response->getContent()));
        }

        return $response;
    }

     /**
     * Check if the header response is text/html.
     *
     * @param \Illuminate\Http\Response $response
     * @return bool
     */
    private function isHtml($response) : bool
    {
        $type = strtolower(strtok($response->headers->get('Content-Type'), ';'));

        return $type === 'text/html';
    }

    /**
     * @param string $html
     *
     * @return string
     */
    private function html(string $html) : string
    {
        return preg_replace(array_keys($this->htmlFilters), array_values($this->htmlFilters), $html);
    }
}
