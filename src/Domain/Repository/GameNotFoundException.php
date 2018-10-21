<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Game\GameIdentifier;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class GameNotFoundException extends \RuntimeException
{
    public static function withId(GameIdentifier $id): self
    {
        $message = sprintf(
            'Could not find game with id "%s"',
            (string) $id
        );

        return new self($message);
    }
}
