<?php

declare(strict_types=1);

namespace App\Infrastructure\Validation\Game;

use Symfony\Component\Validator\Constraint;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class PlayerShouldNotHaveActiveCharacter extends Constraint
{
    public const ERROR_MESSAGE = 'Player already has an active character in game';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
