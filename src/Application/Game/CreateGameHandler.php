<?php

declare(strict_types=1);

namespace App\Application\Game;

use App\Domain\Generator\Character\CharacterGeneratorInterface;
use App\Domain\Model\Game\Game;
use App\Domain\Model\Game\GameCreatedAt;
use App\Domain\Model\Game\GameFinished;
use App\Domain\Model\Game\GameStarted;
use App\Domain\Repository\CharacterRepositoryInterface;
use App\Domain\Repository\GameRepositoryInterface;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class CreateGameHandler
{
    /** @var GameRepositoryInterface */
    private $gameRepository;

    /** @var CharacterRepositoryInterface */
    private $characterRepository;

    /** @var CharacterGeneratorInterface */
    private $characterGenerator;

    public function __construct(
        GameRepositoryInterface $gameRepository,
        CharacterRepositoryInterface $characterRepository,
        CharacterGeneratorInterface $characterGenerator
    ) {
        $this->gameRepository = $gameRepository;
        $this->characterRepository = $characterRepository;
        $this->characterGenerator = $characterGenerator;
    }

    public function __invoke(CreateGameCommand $command): void
    {
        $game = Game::create(
            $this->gameRepository->nextIdentifier(),
            GameCreatedAt::now(),
            GameStarted::fromBoolean(false),
            GameFinished::fromBoolean(false)
        );
        $this->gameRepository->add($game);

        $character = $this->characterGenerator->forGameAndPlayer($game->getId(), $command->playerId);
        $this->characterRepository->add($character);
    }
}
