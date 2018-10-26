<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\InMemory\Game;

use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Query\Game\GameExistsInterface;
use App\Domain\Repository\GameNotFoundException;
use App\Domain\Repository\GameRepositoryInterface;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class InMemoryGameExists implements GameExistsInterface
{
    /** @var GameRepositoryInterface */
    private $gameRepository;

    public function __construct(GameRepositoryInterface $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    public function withIdentifier(GameIdentifier $gameIdentifier): bool
    {
        try {
            $this->gameRepository->getByIdentifier($gameIdentifier);
        } catch (GameNotFoundException $exception) {
            return false;
        }

        return true;
    }
}
