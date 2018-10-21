<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\InMemory\Player;

use App\Domain\Model\Character\Character;
use App\Domain\Model\Player;
use App\Domain\Query\Player\PlayerHasActiveCharacterInterface;
use App\Domain\Repository\CharacterRepositoryInterface;
use App\Domain\Repository\GameRepositoryInterface;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class InMemoryPlayerHasActiveCharacter implements PlayerHasActiveCharacterInterface
{
    /** @var CharacterRepositoryInterface */
    private $characterRepository;

    /** @var GameRepositoryInterface */
    private $gameRepository;

    public function __construct(
        CharacterRepositoryInterface $characterRepository,
        GameRepositoryInterface $gameRepository
    ) {
        $this->characterRepository = $characterRepository;
        $this->gameRepository = $gameRepository;
    }

    public function withPlayer(Player $player): bool
    {
        /** @var Character[] $characters */
        $characters = $this->characterRepository->characters; // TODO: replace by a findBy when method is be available

        foreach ($characters as $character) {
            if (false === $character->getGame()->isFinished()) {
                return true;
            }
        }

        return false;
    }
}
