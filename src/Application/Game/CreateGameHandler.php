<?php

declare(strict_types=1);

namespace App\Application\Game;

use App\Domain\Model\Game;
use App\Domain\Repository\GameRepositoryInterface;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class CreateGameHandler
{
    /** @var GameRepositoryInterface */
    private $gameRepository;

    public function __construct(GameRepositoryInterface $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    public function __invoke(CreateGameCommand $command): void
    {
        $game = Game::create();
        $game->setId($this->gameRepository->nextIdentifier());

        $this->gameRepository->add($game);
    }
}
