<?php

declare(strict_types=1);

namespace App\Infrastructure\Validation\Game;

use App\Application\Player\PlayerJoinsGameCommand;
use App\Domain\Model\Game\Game;
use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Query\Character\CountCharactersByGameInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class GameHasRoomForNewPlayerValidator extends ConstraintValidator
{
    /** @var CountCharactersByGameInterface */
    private $countCharactersByGame;

    public function __construct(CountCharactersByGameInterface $countCharactersByGame)
    {
        $this->countCharactersByGame = $countCharactersByGame;
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
        if (!$constraint instanceof GameHasRoomForNewPlayer) {
            throw new UnexpectedTypeException($constraint, self::class);
        }
    }

    private function validateCommand(PlayerJoinsGameCommand $command): void
    {
        $gameIdentifier = GameIdentifier::fromString($command->gameId);
        $count = $this->countCharactersByGame->withIdentifier($gameIdentifier);

        if ($count >= Game::NUMBER_OF_PLAYERS_REQUIRED_TO_START) {
            $this->context
                ->buildViolation(GameHasRoomForNewPlayer::ERROR_MESSAGE)
                ->addViolation();
        }
    }
}
