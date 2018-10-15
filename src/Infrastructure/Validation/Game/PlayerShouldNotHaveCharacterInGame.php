<?php

declare(strict_types=1);

namespace App\Infrastructure\Validation\Game;

use Symfony\Component\Validator\Constraint;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class PlayerShouldNotHaveCharacterInGame extends Constraint
{
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    // TODO: Maybe not needed anymore with SF4
//    public function validatedBy()
//    {
//        return 'validator.service';
//    }
}
