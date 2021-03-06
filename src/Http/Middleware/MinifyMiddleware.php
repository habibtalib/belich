<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Http\Middleware;

use Closure;
use Daguilarm\Belich\Facades\Belich;
use Illuminate\Http\Request;

/**
 * @author: https://github.com/nckg/laravel-minify-html
 * It is not integrated as a package due to its simplicity (but it is a real awesome!)
 */
final class MinifyMiddleware
{
    private array $htmlFilters = [
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

    private array $htmlSpaces = [
        '{ ' => '{',
        ' }' => '}',
        ' == ' => '==',
        ' === ' => '===',
        ' + ' => '+',
        'for (' => 'for(',
        'if (' => 'if(',
        'while (' => 'while(',
    ];

    private array $exceptedActions = [
        'download',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): object
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
     */
    private function isHtml(object $response, string $type = ''): bool
    {
        $content = $response->headers->get('Content-Type');

        if ($content) {
            $type = strtolower(strtok($content, ';'));

            return $type === 'text/html';
        }

        return $type === 'belich/html';
    }

    /**
     * Filter the html
     */
    private function html(string $html): string
    {
        $html = preg_replace(array_keys($this->htmlFilters), array_values($this->htmlFilters), $html);

        return str_replace(array_keys($this->htmlSpaces), array_values($this->htmlSpaces), $html);
    }
}
