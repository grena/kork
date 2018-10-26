<?php

declare(strict_types=1);

namespace App\Infrastructure\Validation\Game;

use Symfony\Component\Validator\Constraint;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class GameHasRoomForNewPlayer extends Constraint
{
    public const ERROR_MESSAGE = 'This game is full';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
