<?php

declare(strict_types=1);

namespace App\Infrastructure\Validation\Game;

use Symfony\Component\Validator\Constraint;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class PlayerHasNoActiveCharacter extends Constraint
{
    public const ERROR_MESSAGE = 'You already have an active character in game';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
