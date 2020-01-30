<?php

namespace Daguilarm\Belich\Http\Middleware;

use Closure;
use Daguilarm\Belich\Facades\Belich;

/**
 * @author: https://github.com/nckg/laravel-minify-html
 * It is not integrated as a package due to its simplicity (but it is a real awesome!)
 */
final class MinifyMiddleware
{
    /**
     * @var array
     */
    private $htmlFilters = [
        // Remove HTML comments except IE conditions
        '/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s' => '',
        // Remove comments in the form /* */
        // Update from https://manas.tungare.name/software/css-compression-in-php
        '/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\'|\")\/\/.*))/' => '',
        // Shorten multiple white spaces
        '/\s{2,}/' => ' ',
        // Remove whitespaces between HTML tags
        '/>\s{2,}</' => '><',
        // Collapse new lines
        '/(\r?\n)/' => '',
        //Close potential hacking attempts
        '/(\.+\/)/' => '',
    ];

    /**
     * @var array
     */
    private $htmlSpaces = [
        '{ ' => '{',
        ' }' => '}',
        ' == ' => '==',
        ' === ' => '===',
        ' + ' => '+',
        'for (' => 'for(',
        'if (' => 'if(',
        'while (' => 'while(',
    ];

    /**
     * @var array
     */
    private $exceptedActions = [
        'download',
    ];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return object
     */
    public function handle($request, Closure $next): object
    {
        /** @var Response $response */
        $response = $next($request);

        if (config('belich.minifyHtml.enable') && $this->isHtml($response)) {
            //Filter by exclusionary action
            if (in_array(Belich::action(), $this->exceptedActions())) {
                return $response;
            }
            //Filter by url path
            if (in_array(trim($request->path(), '/'), config('belich.minifyHtml.except.paths'))) {
                return $response;
            }

            //Minify
            $response->setContent($this->html($response->getContent()));
        }

        return $response;
    }

    /**
     * Filter Controller actions to be excluded from minify
     *
     * @return array
     */
    private function exceptedActions(): array
    {
        return array_merge(
            $this->exceptedActions,
            config('belich.minifyHtml.except.actions')
        );
    }

    /**
     * Check if the header response is text/html.
     *
     * @param \Illuminate\Http\Response $response
     *
     * @return bool
     */
    private function isHtml($response): bool
    {
        $type = strtolower(strtok($response->headers->get('Content-Type'), ';'));

        return $type === 'text/html';
    }

    /**
     * Filter the html
     *
     * @param string $html
     *
     * @return string
     */
    private function html(string $html): string
    {
        $html = preg_replace(array_keys($this->htmlFilters), array_values($this->htmlFilters), $html);

        return str_replace(array_keys($this->htmlSpaces), array_values($this->htmlSpaces), $html);
    }
}