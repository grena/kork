<?php

declare(strict_types=1);

namespace App\Application\Event\Handler;

use App\Domain\Event\EventHandlerInterface;
use App\Domain\Event\EventInterface;
use App\Domain\Event\Game\PlayerJoinedGameEvent;
use App\Domain\Model\Game\Game;
use App\Domain\Query\Character\CountCharactersByGameInterface;
use App\Domain\Repository\GameRepositoryInterface;

/**
 * When a Player joins a Game, this handler checks if the game has enough player to be started.
 * If it's the case, this handler starts the game.
 *
 * @author Adrien Pétremann <hello@grena.fr>
 */
class StartGameHandler implements EventHandlerInterface
{
    /** @var GameRepositoryInterface */
    private $gameRepository;

    /** @var CountCharactersByGameInterface */
    private $charactersByGame;

    public function __construct(
        GameRepositoryInterface $gameRepository,
        CountCharactersByGameInterface $charactersByGame
    ) {
        $this->gameRepository = $gameRepository;
        $this->charactersByGame = $charactersByGame;
    }

    public function supports(EventInterface $event): bool
    {
        return $event instanceof PlayerJoinedGameEvent;
    }

    public function handle(EventInterface $event): void
    {
        /** @var PlayerJoinedGameEvent $event */
        $playerCount = $this->charactersByGame->withIdentifier($event->getGameIdentifier());

        if ($playerCount === Game::NUMBER_OF_PLAYERS_REQUIRED_TO_START) {
            $game = $this->gameRepository->getByIdentifier($event->getGameIdentifier());
            $game->start();

            $this->gameRepository->update($game);
        }
    }
}
