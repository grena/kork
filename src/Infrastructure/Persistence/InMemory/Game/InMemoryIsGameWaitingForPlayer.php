<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\InMemory\Game;

use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Query\Game\IsGameWaitingForPlayerInterface;
use App\Domain\Repository\GameRepositoryInterface;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class InMemoryIsGameWaitingForPlayer implements IsGameWaitingForPlayerInterface
{
    /** @var GameRepositoryInterface */
    private $gameRepository;

    public function __construct(GameRepositoryInterface $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    public function withIdentifier(GameIdentifier $gameIdentifier): bool
    {
        $game = $this->gameRepository->getByIdentifier($gameIdentifier);

        return !$game->isStarted() && !$game->isFinished();
    }
}
