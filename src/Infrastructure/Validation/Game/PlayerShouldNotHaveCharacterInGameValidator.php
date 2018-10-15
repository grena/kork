<?php

declare(strict_types=1);

namespace App\Infrastructure\Validation\Game;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class PlayerShouldNotHaveCharacterInGameValidator extends ConstraintValidator
{
    public function validate($command, Constraint $constraint)
    {
        // TODO: Do a real check
        $this->context->buildViolation('You already have a character in a game')->addViolation();
    }
}
