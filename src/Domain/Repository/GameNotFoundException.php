<?php

declare(strict_types=1);

namespace App\Domain\Repository;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class GameNotFoundException extends \RuntimeException
{
    public static function withId(string $id): self
    {
        $message = sprintf(
            'Could not find game with id "%s"',
            (string)$id
        );

        return new self($message);
    }
}
