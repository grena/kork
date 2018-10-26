<?php

declare(strict_types=1);

namespace App\Infrastructure\Validation\Game;

use Symfony\Component\Validator\Constraint;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class GameExists extends Constraint
{
    public const ERROR_MESSAGE = 'This game does not exist';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
