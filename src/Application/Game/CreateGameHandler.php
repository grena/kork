<?php

declare(strict_types=1);

namespace App\Application\Game;

use App\Domain\Model\Game\Game;
use App\Domain\Model\Game\GameCreatedAt;
use App\Domain\Model\Game\GameFinished;
use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Model\Game\GameStarted;
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
        $game = Game::create(
            GameIdentifier::fromString($this->gameRepository->nextIdentifier()),
            GameCreatedAt::now(),
            GameStarted::fromBoolean(false),
            GameFinished::fromBoolean(false)
        );

        $this->gameRepository->add($game);
    }
}
