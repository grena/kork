<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\InMemory\Game;

use App\Domain\Model\Character\Character;
use App\Domain\Model\Game\Game;
use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Repository\CharacterRepositoryInterface;
use App\Domain\Repository\GameNotFoundException;
use App\Domain\Repository\GameRepositoryInterface;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class InMemoryGameRepository implements GameRepositoryInterface
{
    /** @var Game[] */
    public $games = [];

    /** @var CharacterRepositoryInterface */
    private $characterRepository;

    public function __construct(
        CharacterRepositoryInterface $characterRepository
    ) {
        $this->characterRepository = $characterRepository;
    }

    public function add(Game $game): void
    {
        $this->games[(string) $game->getId()] = $game;
    }

    public function update(Game $game): void
    {
        $this->games[(string) $game->getId()] = $game;
    }

    public function getByIdentifier(GameIdentifier $identifier): Game
    {
        foreach ($this->games as $game) {
            if ($game->getId()->equals($identifier)) {
                return $game;
            }
        }

        throw GameNotFoundException::withId($identifier);
    }

    public function nextIdentifier(): GameIdentifier
    {
        return GameIdentifier::fromString(
            (string) count($this->games)
        );
    }

    public function findActiveForPlayer(string $playerIdentifier): ?Game
    {
        /** @var Character[] $characters */
        $characters = $this->characterRepository->characters; // TODO: replace by a findByPlayer when method is be available

        foreach ($characters as $character) {
            if ($character->getPlayerIdentifier() === $playerIdentifier) {
                $game = $this->getByIdentifier($character->getGameIdentifier());

                if (!$game->isFinished()) {
                    return $game;
                }
            }
        }

        return null;
    }

    public function reset(): void
    {
        $this->games = [];
    }
}
