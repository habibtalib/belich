<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Components\Helpers;

trait Gravatar
{
    private string $gravatarUrl = 'https://www.gravatar.com/avatar/%s?s=%s&d=%s&r=%s';

    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string|null $email The email address
     * @param int $s Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $d Default imageset to use [ 404 | mp | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     *
     * @source https://gravatar.com/site/implement/images/php/
     */
    public function gravatar(?string $email = null, int $size = 80, string $imageSet = 'mp', string $rating = 'g'): string
    {
        $email = $email
            ? md5(strtolower(trim($email)))
            : auth()->user()->email;

        return sprintf($this->gravatarUrl, $email, $size, $imageSet, $rating);
    }
}
