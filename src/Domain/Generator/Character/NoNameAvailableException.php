<?php

declare(strict_types=1);

namespace App\Domain\Generator\Character;

use App\Domain\Model\Game\GameIdentifier;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class NoNameAvailableException extends \RuntimeException
{
    public static function withGenderAndGame(string $gender, GameIdentifier $gameIdentifier): self
    {
        $message = sprintf(
            'No more available character name for gender "%s" on game with id "%s"',
            $gender,
            $gameIdentifier
        );

        return new self($message);
    }
}
