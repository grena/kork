<?php

declare(strict_types=1);

namespace App\Infrastructure\Validation\Game;

use Symfony\Component\Validator\Constraint;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class GameIsWaitingForPlayer extends Constraint
{
    public const ERROR_MESSAGE = 'This game is not waiting for player';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
