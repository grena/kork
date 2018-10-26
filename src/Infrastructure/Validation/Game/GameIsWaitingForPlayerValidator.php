<?php

declare(strict_types=1);

namespace App\Infrastructure\Validation\Game;

use App\Application\Player\PlayerJoinsGameCommand;
use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Query\Game\IsGameWaitingForPlayerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class GameIsWaitingForPlayerValidator extends ConstraintValidator
{
    /** @var IsGameWaitingForPlayerInterface */
    private $isGameWaitingForPlayer;

    public function __construct(IsGameWaitingForPlayerInterface $isGameWaitingForPlayer)
    {
        $this->isGameWaitingForPlayer = $isGameWaitingForPlayer;
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
        if (!$constraint instanceof GameIsWaitingForPlayer) {
            throw new UnexpectedTypeException($constraint, self::class);
        }
    }

    private function validateCommand(PlayerJoinsGameCommand $command): void
    {
        $gameIdentifier = GameIdentifier::fromString($command->gameId);
        $isWaitingForPlayer = $this->isGameWaitingForPlayer->withIdentifier($gameIdentifier);

        if (!$isWaitingForPlayer) {
            $this->context
                ->buildViolation(GameIsWaitingForPlayer::ERROR_MESSAGE)
                ->addViolation();
        }
    }
}
