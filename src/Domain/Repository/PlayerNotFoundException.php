<?php

declare(strict_types=1);

namespace App\Domain\Repository;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class PlayerNotFoundException extends \RuntimeException
{
    public static function withId(string $id): self
    {
        $message = sprintf(
            'Could not find player with id "%s"',
            (string) $id
        );

        return new self($message);
    }
}
