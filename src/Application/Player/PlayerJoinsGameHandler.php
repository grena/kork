<?php

declare(strict_types=1);

namespace App\Application\Player;

use App\Domain\Event\EventPublisherInterface;
use App\Domain\Event\Game\PlayerJoinedGameEvent;
use App\Domain\Generator\Character\CharacterGeneratorInterface;
use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Repository\CharacterRepositoryInterface;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class PlayerJoinsGameHandler
{
    /** @var CharacterGeneratorInterface */
    private $characterGenerator;

    /** @var CharacterRepositoryInterface */
    private $characterRepository;

    /** @var EventPublisherInterface */
    private $eventPublisher;

    public function __construct(
        CharacterGeneratorInterface $characterGenerator,
        CharacterRepositoryInterface $characterRepository,
        EventPublisherInterface $eventPublisher
    ) {
        $this->characterGenerator = $characterGenerator;
        $this->characterRepository = $characterRepository;
        $this->eventPublisher = $eventPublisher;
    }

    public function __invoke(PlayerJoinsGameCommand $command)
    {
        $gameIdentifier = GameIdentifier::fromString($command->gameId);

        $character = $this->characterGenerator->forGameAndPlayer($gameIdentifier, $command->playerId);
        $this->characterRepository->add($character);

        $this->eventPublisher->publish(PlayerJoinedGameEvent::create(
            $command->playerId,
            $gameIdentifier
        ));
    }
}
