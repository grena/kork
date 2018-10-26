<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\InMemory\Character;

use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Query\Character\CountCharactersByGameInterface;
use App\Domain\Repository\CharacterRepositoryInterface;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class InMemoryCountCharactersByGame implements CountCharactersByGameInterface
{
    /** @var CharacterRepositoryInterface */
    private $characterRepository;

    public function __construct(CharacterRepositoryInterface $characterRepository)
    {
        $this->characterRepository = $characterRepository;
    }

    public function withIdentifier(GameIdentifier $gameIdentifier): int
    {
        $characters = $this->characterRepository->findAllByGame($gameIdentifier);

        return count($characters);
    }
}
