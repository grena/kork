<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\InMemory\Character;

use App\Domain\Model\Character\Character;
use App\Domain\Model\Character\CharacterIdentifier;
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
}
