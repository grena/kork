<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\InMemory\Game;

use App\Domain\Model\Game\Game;
use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Repository\GameNotFoundException;
use App\Domain\Repository\GameRepositoryInterface;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class InMemoryGameRepository implements GameRepositoryInterface
{
    /** @var Game[] */
    public $games = [];

    public function add(Game $game): void
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
}
