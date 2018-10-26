<?php

declare(strict_types=1);

namespace App\Infrastructure\Validation\Game;

use App\Application\Player\PlayerJoinsGameCommand;
use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Query\Game\GameExistsInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class GameExistsValidator extends ConstraintValidator
{
    /** @var GameExistsInterface */
    private $gameExists;

    public function __construct(GameExistsInterface $gameExists)
    {
        $this->gameExists = $gameExists;
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
        if (!$command instanceof PlayerJoinsGameCommand) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Expected argument to be of class "%s", "%s" given',
                    PlayerJoinsGameCommand::class,
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
        if (!$constraint instanceof GameExists) {
            throw new UnexpectedTypeException($constraint, self::class);
        }
    }

    private function validateCommand(PlayerJoinsGameCommand $command): void
    {
        $gameIdentifier = GameIdentifier::fromString($command->gameId);

        if (!$this->gameExists->withIdentifier($gameIdentifier)) {
            $this->context
                ->buildViolation(GameExists::ERROR_MESSAGE)
                ->addViolation();
        }
    }
}
