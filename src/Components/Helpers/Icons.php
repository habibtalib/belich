<?php

namespace Daguilarm\Belich\Components\Helpers;

trait Icons
{
    /**
     * @var string
     */
    private $gravatarUrl = 'https://www.gravatar.com/avatar/%s?s=%s&d=%s&r=%s';

    /**
     * Render the icons
     *
     * @param string $icon
     * @param string $text
     * @param string $css
     *
     * @return string
     */
    public function icon(string $icon, string $text = '', string $css = ''): string
    {
        // Set right margin if we have text
        $margin = $text ? ' mr-2' : '';

        //Set the css
        $css = $css ? ' ' . $css : ' icon';

        return sprintf('<i class="fas fa-%s%s%s"></i>%s', $icon, $margin, $css, $text);
    }

    /**
     * Render the action icons
     *
     * @param string $icon
     *
     * @return string
     */
    public function actionIcon(string $icon): string
    {
        return sprintf('<i class="fas fa-%s"></i>', $icon);
    }

    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string|null $email The email address
     * @param int $s Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $d Default imageset to use [ 404 | mp | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     *
     * @source https://gravatar.com/site/implement/images/php/
     *
     * @return  string
     */
    public function gravatar(?string $email = null, int $size = 80, string $imageSet = 'mp', string $rating = 'g'): string
    {
        $email = $email
            ? md5(strtolower(trim($email)))
            : auth()->user()->email;

        return sprintf($this->gravatarUrl, $email, $size, $imageSet, $rating);
    }
}
