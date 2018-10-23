<?php

declare(strict_types=1);

namespace App\Infrastructure\Validation\Game;

use App\Application\Game\CreateGameCommand;
use App\Application\Player\PlayerJoinsRandomGameCommand;
use App\Domain\Query\Player\PlayerHasActiveCharacterInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class PlayerShouldNotHaveActiveCharacterValidator extends ConstraintValidator
{
    /** @var PlayerHasActiveCharacterInterface */
    private $hasActiveCharacter;

    public function __construct(PlayerHasActiveCharacterInterface $hasActiveCharacter)
    {
        $this->hasActiveCharacter = $hasActiveCharacter;
    }

    public function validate($command, Constraint $constraint)
    {
        $this->checkConstraintType($constraint);
        $this->checkCommandType($command);
        $this->validateCommand($command);
    }

    /**
     * @throws \InvalidArgumentException
     */
    private function checkCommandType($command): void
    {
        if (!$command instanceof CreateGameCommand && !$command instanceof PlayerJoinsRandomGameCommand) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Expected argument to be of class "%s" or "%s", "%s" given',
                    CreateGameCommand::class,
                    PlayerJoinsRandomGameCommand::class,
                    get_class($command)
                )
            );
        }
    }
    /**
     * @throws UnexpectedTypeException
     */
    private function checkConstraintType(Constraint $constraint): void
    {
        if (!$constraint instanceof PlayerShouldNotHaveActiveCharacter) {
            throw new UnexpectedTypeException($constraint, self::class);
        }
    }

    private function validateCommand($command)
    {
        $hasActiveCharacter = $this->hasActiveCharacter->withPlayer($command->playerId);

        if ($hasActiveCharacter) {
            $this->context
                ->buildViolation(PlayerShouldNotHaveActiveCharacter::ERROR_MESSAGE)
                ->addViolation();
        }
    }
}
