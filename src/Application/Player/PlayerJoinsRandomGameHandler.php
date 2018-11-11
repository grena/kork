<?php

declare(strict_types=1);

namespace App\Application\Player;

use App\Domain\Event\EventPublisherInterface;
use App\Domain\Event\Game\PlayerJoinedGameEvent;
use App\Domain\Generator\Character\CharacterGeneratorInterface;
use App\Domain\Model\Game\Game;
use App\Domain\Query\Game\FindAllGamesWaitingForPlayerInterface;
use App\Domain\Repository\CharacterRepositoryInterface;
use App\Domain\Repository\GameRepositoryInterface;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class PlayerJoinsRandomGameHandler
{
    /** @var FindAllGamesWaitingForPlayerInterface */
    private $findAllGamesWaitingForPlayer;

    /** @var CharacterGeneratorInterface */
    private $characterGenerator;

    /** @var GameRepositoryInterface */
    private $gameRepository;

    /** @var CharacterRepositoryInterface */
    private $characterRepository;

    /** @var EventPublisherInterface */
    private $eventPublisher;

    public function __construct(
        FindAllGamesWaitingForPlayerInterface $findAllGamesWaitingForPlayer,
        CharacterGeneratorInterface $characterGenerator,
        GameRepositoryInterface $gameRepository,
        CharacterRepositoryInterface $characterRepository,
        EventPublisherInterface $eventPublisher
    ) {
        $this->findAllGamesWaitingForPlayer = $findAllGamesWaitingForPlayer;
        $this->characterGenerator = $characterGenerator;
        $this->gameRepository = $gameRepository;
        $this->characterRepository = $characterRepository;
        $this->eventPublisher = $eventPublisher;
    }

    public function __invoke(PlayerJoinsRandomGameCommand $command)
    {
        $availableGames = ($this->findAllGamesWaitingForPlayer)();

        if (empty($availableGames)) {
            $game = Game::createNew($this->gameRepository->nextIdentifier());
            $this->gameRepository->add($game);

            $gameIdentifier = $game->getId();
        } else {
            $gameIdentifier = $availableGames[array_rand($availableGames)];
        }

        $character = $this->characterGenerator->forGameAndPlayer($gameIdentifier, $command->playerId);
        $this->characterRepository->add($character);

        $this->eventPublisher->publish(PlayerJoinedGameEvent::create(
            $command->playerId,
            $gameIdentifier
        ));
    }
}
