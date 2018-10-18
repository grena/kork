<?php

declare(strict_types=1);

namespace App\Infrastructure\Validation\Game;

use App\Application\Game\CreateGameCommand;
use App\Domain\Query\Player\PlayerHasActiveCharacterInterface;
use App\Domain\Repository\PlayerRepositoryInterface;
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

    /** @var PlayerRepositoryInterface */
    private $playerRepository;

    public function __construct(
        PlayerHasActiveCharacterInterface $hasActiveCharacter,
        PlayerRepositoryInterface $playerRepository
    ) {
        $this->hasActiveCharacter = $hasActiveCharacter;
        $this->playerRepository = $playerRepository;
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
        if (!$command instanceof CreateGameCommand) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Expected argument to be of class "%s", "%s" given',
                    CreateGameCommand::class,
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

    private function validateCommand(CreateGameCommand $command)
    {
        $player = $this->playerRepository->getById($command->playerId);
        $hasActiveCharacter = $this->hasActiveCharacter->withPlayer($player);

        if ($hasActiveCharacter) {
            $this->context
                ->buildViolation(PlayerShouldNotHaveActiveCharacter::ERROR_MESSAGE)
                ->addViolation();
        }
    }
}