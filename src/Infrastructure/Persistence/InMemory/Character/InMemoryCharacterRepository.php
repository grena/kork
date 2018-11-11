<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\InMemory\Character;

use App\Domain\Model\Character\Character;
use App\Domain\Model\Character\CharacterIdentifier;
use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Repository\CharacterRepositoryInterface;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class InMemoryCharacterRepository implements CharacterRepositoryInterface
{
    /** @var Character[] */
    public $characters = [];

    public function add(Character $character): void
    {
        $this->characters[(string) $character->getId()] = $character;
    }

    public function nextIdentifier(): CharacterIdentifier
    {
        return CharacterIdentifier::fromString(
            (string) count($this->characters)
        );
    }

    /**
     * @return Character[]
     */
    public function findAllByGame(GameIdentifier $gameIdentifier): array
    {
        $characters = array_filter($this->characters, function (Character $character) use ($gameIdentifier) {
            return $character->getGameIdentifier()->equals($gameIdentifier);
        });

        return array_values($characters);
    }

    public function reset(): void
    {
        $this->characters = [];
    }
}
