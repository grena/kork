<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\InMemory\Game;

use App\Domain\Model\Game\Game;
use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Query\Game\FindAllGamesWaitingForPlayerInterface;
use App\Domain\Repository\CharacterRepositoryInterface;
use App\Domain\Repository\GameRepositoryInterface;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class InMemoryFindAllGamesWaitingForPlayer implements FindAllGamesWaitingForPlayerInterface
{
    /** @var GameRepositoryInterface */
    private $gameRepository;

    /** @var CharacterRepositoryInterface */
    private $characterRepository;

    public function __construct(
        GameRepositoryInterface $gameRepository,
        CharacterRepositoryInterface $characterRepository
    ) {
        $this->gameRepository = $gameRepository;
        $this->characterRepository = $characterRepository;
    }

    /**
     * @return GameIdentifier[]
     */
    public function __invoke(): array
    {
        $gameIdentifiers = [];

        /** @var Game $game */
        foreach ($this->gameRepository->games as $game) {
            $gameIdentifier = $game->getId();
            $charactersInGame = $this->characterRepository->findAllByGame($gameIdentifier);

            if ($game->isStarted()) {
                continue;
            }

            if ($game->isFinished()) {
                continue;
            }

            if (count($charactersInGame) < Game::NUMBER_OF_PLAYERS_REQUIRED_TO_START) {
                $gameIdentifiers[] = $gameIdentifier;
            }
        }

        return $gameIdentifiers;
    }
}
